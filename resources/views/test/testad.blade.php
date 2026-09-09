<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Active Directory test</title>
	<style>
		body { background: #f4f7f9; color: #17212b; font-family: Arial, sans-serif; margin: 0; }
		main { margin: 6rem auto; max-width: 680px; padding: 0 1.25rem; }
		section { background: #fff; border: 1px solid #dce4e8; border-radius: 8px; padding: 2rem; box-shadow: 0 10px 30px rgb(23 33 43 / 8%); }
		h1 { margin-top: 0; }
		label { display: block; font-weight: 700; margin: 1rem 0 .35rem; }
		input { border: 1px solid #b9c6ce; border-radius: 4px; box-sizing: border-box; font: inherit; padding: .7rem; width: 100%; }
		button { background: #0b6e69; border: 0; border-radius: 4px; color: #fff; cursor: pointer; font: inherit; font-weight: 700; margin-top: 1.25rem; padding: .75rem 1.25rem; }
		dl { display: grid; grid-template-columns: 140px 1fr; gap: .5rem 1rem; margin: 1.5rem 0; }
		dt { color: #5a6872; font-weight: 700; }
		dd { margin: 0; overflow-wrap: anywhere; }
		.result { border-left: 4px solid #0b6e69; margin-bottom: 1.5rem; padding: .75rem 1rem; }
		.result.failure { border-color: #b42318; }
		table { border-collapse: collapse; margin: 1.5rem 0; width: 100%; }
		th, td { border-bottom: 1px solid #dce4e8; padding: .6rem .4rem; text-align: left; vertical-align: top; }
		th { color: #5a6872; font-size: .85rem; text-transform: uppercase; }
		td { overflow-wrap: anywhere; }
		.hint { color: #5a6872; }
	</style>
</head>
<body>
<main>
	<section>
		<h1>Active Directory connection test</h1>

		@isset($result)
			<div class="result {{ $result['success'] ? '' : 'failure' }}" role="status">
				{{ $result['message'] }}
			</div>
		@endisset

		@if (!empty($result['attributes'] ?? []))
			<h2>Authenticated AD attributes</h2>
			<table>
				<thead><tr><th>Attribute</th><th>Value</th></tr></thead>
				<tbody>
				@foreach ($result['attributes'] as $attribute => $value)
					<tr><td>{{ $attribute }}</td><td>{{ $value }}</td></tr>
				@endforeach
				</tbody>
			</table>
		@endif

		<dl>
			<dt>Host</dt><dd>{{ $connection['host'] ?: 'Not configured' }}</dd>
			<dt>Port</dt><dd>{{ $connection['port'] ?: 'Not configured' }}</dd>
			<dt>Base DN</dt><dd>{{ $connection['base_dn'] ?: 'Not configured' }}</dd>
			<dt>SSL</dt><dd>{{ $connection['ssl'] ? 'Enabled' : 'Disabled' }}</dd>
			<dt>StartTLS</dt><dd>{{ $connection['tls'] ? 'Enabled' : 'Disabled' }}</dd>
		</dl>

		<form method="post" action="{{ route('test.ad.authenticate') }}">
			@csrf
			<label for="username">AD username</label>
			<input id="username" name="username" value="{{ old('username', $username ?? '') }}" autocomplete="username" required>

			<label for="password">AD password</label>
			<input id="password" name="password" type="password" autocomplete="current-password" required>

			@error('username') <p>{{ $message }}</p> @enderror
			@error('password') <p>{{ $message }}</p> @enderror
			<button type="submit">Test AD login</button>
		</form>
	</section>
</main>
</body>
</html>
