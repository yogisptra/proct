<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\Models\PasswordResset;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Hash, DB, Cache;

class PasswordRessetRepository extends Apprepository{
    protected $model;
    protected $modelUser;

    public function __construct(PasswordResset $model, Donatur $modelUser)
    {
        $this->model = $model;
        $this->modelUser = $modelUser;
    }

    /**
     * get collection of items in paginate format.
     * 
     * @return Collection of items.
     */
    public function paginate(Request $request)
    {
        $data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->model->orderBy('created_at','DESC')->paginate($request->input('limit', 15));
            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }
        return $data;
    }

    protected function setDataPayload(Request $request)
    {
		$token = Str::random(60);
        return [
            'email' 		=> isset($request['email']) ? $request->input('email') : null,
			'name'			=> isset($request['name']) ? $request->input('name') : null,
            'phone_number'  => isset($request['phone_number']) ? $request->input('phone_number') : null,
            'token' 		=> $token,
        ];
    }

	public function getByEmail($email)
	{
		$data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->model->where('email', $email)->first();

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }

        return $data;
	}

    public function getByPhone($phone)
	{
		$data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->model->where('phone_number', $phone)->first();

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }

        return $data;
	}

    public function getByUserPhone($phone)
	{
		$data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->modelUser->where('phone_number', $phone)->first();

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }

        return $data;
	}

    public function getByUserEmail($email)
	{
		$data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->modelUser->where('email', $email)->first();

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }

        return $data;
	}

	public function getByToken($token)
	{
		$data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->model->where('token', $token)->first();

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }

        return $data;
	}

	public function updatePassword(Request $request){
		$user = NULL;
        DB::beginTransaction();
        try {
            $user = $this->modelUser->where('email', $request->email)->first();
			$user->update([
				'password' => Hash::make($request['password'])
			]);

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $user = $th;
        }

        return $user;
	}

	public function deleteToken($email){
		return $this->model->where('email', $email)->delete();
	}

}