<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Models\TrainingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    private TrainingModel $trainingModel;

    public function __construct()
    {
        $this->trainingModel = new TrainingModel();
    }

    public function getAll()
    {
        $user = Auth::user();

        $users = $this->trainingModel->query()->get();

        return $this->success('Listando todos os treinos', $users, 200);
    }

    public function getById($id)
    {
        $user = Auth::user();

        $user = $this->trainingModel::where('id', $id)->first();

        if (!$user) {
            return $this->error('Esse treino não existe', 404);
        }

        return $this->success('treino encontrado', $user, 200);
    }

    public function create(Request $request)
    {
        $user = $this->trainingModel::create([
            'exercise_name' => $request->all()['exercise_name'],
            'url_video_img' => $request->all()['url_video_img'],
            'sets' => $request->all()['sets'],
            'repes' => $request->all()['repes'],
            'rest_time' => $request->all()['rest_time'],
            'day' => $request->all()['day'],
            'id_user' => $request->all()['id_user'],
            'id_personal_code' => $request->all()['id_personal_code'],
            'position' => $request->all()['position']
        ]);

        return $this->success('treino criado com sucesso', $user, 201);
    }

    public function update(UpdateTrainingRequest $request, $id)
    {
        $user = Auth::user();

        $user = $this->trainingModel::find($id);

        if (!$user) {
            return $this->error('Esse treino não existe', 404);
        }

        $user->fill($request->only(['name', 'email', 'password']));
        $user->save();

        return $this->success('treino atualizado com sucesso', $user, 200);
    }

    public function delete($id)
    {
        $user = Auth::user();

        $user = $this->trainingModel::where('id', $id)->first();

        if (!$user) {
            return $this->error('Esse treino não existe', 404);
        }

        if (!$user->active) {
            return $this->error('Esse treino ja esta desativado', 422);
        }

        $user->active = false;

        $user->save();

        return $this->success('treino desativado com sucesso', $user, 200);
    }

    public function updateActive($id)
    {
        $user = Auth::user();

        $user = $this->trainingModel::where('id', $id)->first();

        if (!$user) {
            return $this->error('Esse treino não existe', 404);
        } 

        if ($user->active) {
            return $this->error('Esse treino ja esta ativo', 422);
        }

        $user -> active = true;

        $user -> save();

        return $this->success('treino ativado com sucesso', $user, 200);
    }
}
