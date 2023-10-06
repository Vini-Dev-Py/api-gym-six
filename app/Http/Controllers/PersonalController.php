<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePersonalRequest;
use App\Http\Requests\UpdatePersonalRequest;
use App\Models\PersonalModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalController extends Controller
{
    private PersonalModel $personalModel;

    public function __construct()
    {
        $this->personalModel = new PersonalModel();
    }

    public function getAll()
    {
        $user = Auth::user();

        $personals = $this->personalModel->query()->get();

        $personals->load('user');

        return $this->success('Listando todos os professores', $personals, 200);
    }

    public function getById($id)
    {
        $user = Auth::user();

        $personal = $this->personalModel::where('id', $id)->first();

        if (!$personal) {
            return $this->error('Esse professor não existe', 404);
        }

        $personal->load('user');

        return $this->success('Professor encontrado', $personal, 200);
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        $personal = $this->personalModel::create([
            'personal_code' => rand(10000, 99999),
            'id_user' => $user->id
        ]);

        return $this->success('Professor criado com sucesso', $personal, 201);
    }

    public function update(UpdatePersonalRequest $request, $id)
    {
        $user = Auth::user();

        $personal = $this->personalModel::find($id);

        if (!$personal) {
            return $this->error('Esse Professor não existe', 404);
        }

        $personal->fill($request->only([]));
        $personal->save();

        return $this->success('Professor atualizado com sucesso', $user, 200);
    }

    public function delete($id)
    {
        $user = Auth::user();

        $personal = $this->personalModel::where('id', $id)->first();

        if (!$personal) {
            return $this->error('Esse professor não existe', 404);
        }

        if (!$personal->active) {
            return $this->error('Esse professor ja esta desativado', 422);
        }

        $personal->active = false;

        $personal->save();

        return $this->success('Professor desativado com sucesso', $personal, 200);
    }

    public function updateActive($id)
    {
        $user = Auth::user();

        $personal = $this->personalModel::where('id', $id)->first();

        if (!$personal) {
            return $this->error('Esse professor não existe', 404);
        } 

        if ($personal->active) {
            return $this->error('Esse professor ja esta ativo', 422);
        }

        $personal -> active = true;

        $personal -> save();

        return $this->success('Professor ativado com sucesso', $personal, 200);
    }
}
