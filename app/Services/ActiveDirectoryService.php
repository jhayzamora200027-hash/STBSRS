<?php

namespace App\Services;

use LdapRecord\Container;
use LdapRecord\Models\ActiveDirectory\User;
use Throwable;

class ActiveDirectoryService
{
	public function authenticate(string $username, string $password): array
	{
		$username = $this->normalizeUsername($username);

		if (! extension_loaded('ldap')) {
			return [
				'success' => false,
				'message' => 'PHP LDAP is not enabled. Enable extension=ldap in the PHP installation used by Laravel, then restart the server.',
			];
		}

		if (! class_exists(Container::class)) {
			return [
				'success' => false,
				'message' => 'LDAPRecord is not installed. Run composer update directorytree/ldaprecord-laravel --with-dependencies after enabling PHP LDAP.',
			];
		}

		try {
			$connection = Container::getConnection(config('ldap.default', 'default'));
			$authenticated = $connection
				->auth()
				->attempt($username, $password, true);
			$attributes = $authenticated ? $this->findUserAttributes($username) : [];

			return [
				'success' => $authenticated,
				'attributes' => $attributes,
				'message' => $authenticated
					? 'Active Directory credentials are valid.'
					: 'Active Directory rejected these credentials.',
			];
		} catch (Throwable $exception) {
			report($exception);
			$message = config('app.debug')
				? ' AD error: '. $exception->getMessage()
				: '';

			return [
				'success' => false,
				'message' => 'Active Directory could not be reached or is not configured. Check the application log for details.'. $message,
			];
		}
	}

	private function findUserAttributes(string $username): array
	{
		$accountName = explode('@', $username, 2)[0];
		$user = User::query()
			->where('userprincipalname', '=', $username)
			->first()
			?? User::query()->where('samaccountname', '=', $accountName)->first();

		if (! $user) {
			return [];
		}

		$hidden = [
			'unicodepwd',
			'userpassword',
			'password',
			'objectsid',
			'objectguid',
		];

		return collect($user->getAttributes())
			->reject(fn ($value, $key) => in_array(strtolower($key), $hidden, true))
			->map(fn ($value) => is_array($value) ? implode(', ', array_map('strval', $value)) : (string) $value)
			->sortKeys()
			->all();
	}

	private function normalizeUsername(string $username): string
	{
		$suffix = trim((string) config('services.active_directory.user_suffix'));

		if ($suffix !== '' && ! str_contains($username, '@') && ! str_contains($username, '\\')) {
			return $username.'@'.ltrim($suffix, '@');
		}

		return $username;
	}
}
