<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\TrainingModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private UserModel $userModel;
    private TrainingModel $trainingModel;

    const DAYS = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->trainingModel = new TrainingModel();
    }

    public function getAll()
    {
        $user = Auth::user();

        $users = $this->userModel->query()->get();

        foreach ($users as $user) {
            $user->load('personal');

            $daysOfWeekStructure = $user->getDaysOfWeekStructure();

            foreach (self::DAYS as $day) {

                $trainingByUser = $this->trainingModel::where('id_user', $user->id)->orderBy("position", "asc")->get();

                foreach ($trainingByUser as $training) {
    
                    if ($training->day === $day) {
                        $daysOfWeekStructure[$day][] = $training;
                    }
                }
    
                $user->days = $daysOfWeekStructure;
            }
        }

        return $this->success('Listando todos os usuários', $users, 200);
    }

    public function getById($id)
    {
        $user = Auth::user();

        $user = $this->userModel::where('id', $id)->first();

        $trainingByUser = $this->trainingModel::where('id_user', $user->id)->orderBy("position", "asc")->get();

        if (!$user) {
            return $this->error('Esse usuário não existe', 404);
        }

        $user->load('personal');

        $daysOfWeekStructure = $user->getDaysOfWeekStructure();

        foreach (self::DAYS as $day) {
            foreach ($trainingByUser as $training) {

                if ($training->day === $day) {
                    $daysOfWeekStructure[$day][] = $training;
                }
            }

            $user->days = $daysOfWeekStructure;
        }

        return $this->success('Usuário encontrado', $user, 200);
    }

    public function create(Request $request)
    {
        $user = $this->userModel::create([
            'name' => $request->all()['name'],
            'email' => $request->all()['email'],
            'password' => Hash::make($request->all()['password']),
            'role' => $request->all()['role'],
            'phone' => $request->all()['phone'],
            'RG' => isset($request->all()['RG']) ? $request->all()['RG'] : null,
            'CPF' => $request->all()['CPF']
        ]);

        return $this->success('Usuário criado com sucesso', $user, 201);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = Auth::user();

        $user = $this->userModel::find($id);

        if (!$user) {
            return $this->error('Esse usuário não existe', 404);
        }

        $user->fill($request->only(['name', 'email', 'password']));
        $user->save();

        return $this->success('Usuário atualizado com sucesso', $user, 200);
    }

    public function delete($id)
    {
        $user = Auth::user();

        $user = $this->userModel::where('id', $id)->first();

        if (!$user) {
            return $this->error('Esse usuário não existe', 404);
        }

        if (!$user->active) {
            return $this->error('Esse usuário ja esta desativado', 422);
        }

        $user->active = false;

        $user->save();

        return $this->success('Usuário desativado com sucesso', $user, 200);
    }

    public function updateActive($id)
    {
        $user = Auth::user();

        $user = $this->userModel::where('id', $id)->first();

        if (!$user) {
            return $this->error('Esse usuário não existe', 404);
        } 

        if ($user->active) {
            return $this->error('Esse usuário ja esta ativo', 422);
        }

        $user -> active = true;

        $user -> save();

        return $this->success('Usuário ativado com sucesso', $user, 200);
    }

    public function updatePersonalCode($id)
    {
        
    }
}
