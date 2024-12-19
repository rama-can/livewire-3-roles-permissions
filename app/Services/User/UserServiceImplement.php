<?php

namespace App\Services\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserServiceImplement implements UserService
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new record.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            if (isset($data['image']) && $data['image']->isValid()) {
                $extension = $data['image']->getClientOriginalExtension();

                $imagePath = $data['image']->storeAs('images/profile', time() . '.' . $extension, 'public');

                $data['profile_photo_path'] = $imagePath;
            }

            unset($data['image']);

            // $username = $this->generateUniqueUsername($data['name']);
            if (empty($data['username'])) {
                $username = $this->generateUniqueUsername($data['name'] ?? null);
            } else {
                // Validasi keunikan username jika disediakan
                $username = $this->generateUniqueUsername($data['username']);
            }

            $result = $this->model->create([
                'name' => $data['name'],
                'username' => $username,
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'password' => Hash::make($data['password']),
                'email_verified_at' => now(),
                'profile_photo_path' => $data['profile_photo_path'],
                'date_of_birth' => $data['dob'],
                'zip' => $data['zip'],
                'country' => $data['country'],
            ]);

            // assign role
            $role = Role::find($data['role']);
            $result->assignRole($role);

            DB::commit();

            return [
                'status' => true,
                'data' => $result
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Update a record.
     *
     * @param int $id
     * @param array $data
     * @return User
     */
    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->model->findOrFail($id);

            if (isset($data['image']) && $data['image']->isValid()) {
                if ($user->profile_photo_path) {
                    // Storage::disk('public')->delete(str_replace('storage/', '', $user->profile_photo_path));
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                $extension = $data['image']->getClientOriginalExtension();
                $imagePath = $data['image']->storeAs('images/profile', time() . '.' . $extension, 'public');

                $data['profile_photo_path'] = $imagePath;
            }

            unset($data['image']);

            // Perbarui password jika tersedia dalam data
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            // Sinkronisasi role jika disediakan
            if (!empty($data['role'])) {
                $user->syncRoles([$data['role']]);
                unset($data['role']);
            }

            $user->update($data);
            DB::commit();

            return [
                'status' => true,
                'data' => $user
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $result = $this->model->findOrFail($id);

            if ($result->profile_photo_path) {
                Storage::disk('public')->delete($result->profile_photo_path);
            }

            $result->delete();
            DB::commit();

            return [
                'status' => true,
                'data' => $result
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate a unique username based on the user's name.
     *
     * @param string $name
     * @return string
     */
    public function generateUniqueUsername(?string $name): string
    {
        // Jika nama tidak tersedia, gunakan string default "username"
        $baseUsername = $name ? Str::slug($name, '_') : 'username';

        // Bersihkan username agar sesuai aturan: huruf kecil, angka, dan underscores, tanpa underscore di awal/akhir
        $baseUsername = strtolower(preg_replace('/[^a-z0-9_]/', '', $baseUsername));
        $baseUsername = trim($baseUsername, '_');

        // Pastikan username tidak lebih dari 15 karakter
        $baseUsername = substr($baseUsername, 0, 15);

        // Jika username dasar belum ada, langsung gunakan
        if (!$this->model->where('username', $baseUsername)->exists()) {
            return $baseUsername;
        }

        // Jika sudah ada, tambahkan string acak di akhir untuk membuatnya unik
        do {
            $username = $baseUsername . '_' . Str::random(3); // Menambahkan random string untuk membuatnya unik
            $username = substr($username, 0, 15); // Pastikan tetap maksimal 15 karakter
        } while ($this->model->where('username', $username)->exists());

        return $username;
    }
}
