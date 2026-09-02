<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureSysadmin();

        $search = trim((string) $request->input('search'));
        $status = (string) $request->input('status');
        $search = addcslashes($search, '\\%_');

        $programs = Program::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('program_id', 'like', "%{$search}%")
                        ->orWhere('program', 'like', "%{$search}%");
                });
            })
            ->when(in_array($status, ['active', 'inactive'], true), fn ($query) => $query->where('status', $status))
            ->with('creator')
            ->orderBy('program')
            ->paginate(10)
            ->withQueryString();

        return view('authpage.admin.programs', [
            'programs' => $programs,
            'totalPrograms' => Program::count(),
            'activePrograms' => Program::where('status', 'active')->count(),
            'inactivePrograms' => Program::where('status', 'inactive')->count(),
            'nextProgramCode' => $this->nextProgramCode(),
            'filters' => compact('search', 'status'),
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureSysadmin();

        $validated = $request->validate([
            'program' => ['required', 'string', 'max:255', 'unique:programs,program'],
        ]);

        Program::create($validated + [
            'program_id' => $this->nextProgramCode(),
            'created_by' => Auth::id(),
            'status' => 'active',
        ]);

        return back()->with('program_success', 'The program has been added.');
    }

    public function update(Request $request, Program $program)
    {
        $this->ensureSysadmin();

        $validated = $request->validate([
            'program' => ['required', 'string', 'max:255', 'unique:programs,program,' . $program->id],
        ]);

        $program->update($validated);

        return back()->with('program_success', 'The program has been updated.');
    }

    public function toggleStatus(Program $program)
    {
        $this->ensureSysadmin();

        $program->update([
            'status' => $program->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('program_success', 'The program status has been updated.');
    }

    private function nextProgramCode(): string
    {
        $nextNumber = Program::query()->pluck('program_id')->reduce(function (int $highest, string $programId): int {
            if (preg_match('/^PRG-(\d+)$/i', $programId, $matches)) {
                return max($highest, (int) $matches[1]);
            }

            return $highest;
        }, 0) + 1;

        return 'PRG-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }

    private function ensureSysadmin(): void
    {
        abort_unless(Auth::user()?->usergroup === 'sysadmin', 403);
    }
}