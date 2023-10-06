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

        $trainings = $this->trainingModel->query()->get();

        return $this->success('Listando todos os treinos', $trainings, 200);
    }

    public function getAllByMember($id)
    {
        $user = Auth::user();

        $training = $this->trainingModel->query()->where("id_user", "=", $id)->orderBy("position", "asc")->get();

        return $this->success("Listando todos os treinos do membro", $training, 200);
    }

    public function getById($id)
    {
        $user = Auth::user();

        $training = $this->trainingModel::where('id', $id)->first();

        if (!$user) {
            return $this->error('Esse treino não existe', 404);
        }

        return $this->success('treino encontrado', $training, 200);
    }

    public function create(Request $request)
    {
        $training = $this->trainingModel::create([
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

        return $this->success('treino criado com sucesso', $training, 201);
    }

    public function update(UpdateTrainingRequest $request, $id)
    {
        $user = Auth::user();

        $training = $this->trainingModel::find($id);

        if (!$user) {
            return $this->error('Esse treino não existe', 404);
        }

        $training->fill($request->only(['name', 'email', 'password']));
        $training->save();

        return $this->success('treino atualizado com sucesso', $training, 200);
    }

    public function delete($id)
    {
        $user = Auth::user();

        $training = $this->trainingModel::where('id', $id)->first();

        if (!$training) {
            return $this->error('Esse treino não existe', 404);
        }

        if (!$training->active) {
            return $this->error('Esse treino ja esta desativado', 422);
        }

        $training->active = false;

        $training->save();

        return $this->success('treino desativado com sucesso', $training, 200);
    }

    public function updateActive($id)
    {
        $user = Auth::user();

        $training = $this->trainingModel::where('id', $id)->first();

        if (!$training) {
            return $this->error('Esse treino não existe', 404);
        } 

        if ($training->active) {
            return $this->error('Esse treino ja esta ativo', 422);
        }

        $training -> active = true;

        $training -> save();

        return $this->success('treino ativado com sucesso', $training, 200);
    }
}
