<?php

namespace App\Http\Controllers;

use App\Models\PersonalModel;
use App\Models\PersonalUsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalUsersController extends Controller
{
    private PersonalUsersModel $personalUsersModel;
    private PersonalModel $personalModel;

    public function __construct()
    {
        $this->personalUsersModel = new PersonalUsersModel();
        $this->personalModel= new PersonalModel();
    }

    public function getUsersByPersonal($id_personal)
    {
        $personal = $this->personalModel::where("id_user", $id_personal)->first();

        $users = $this->personalUsersModel->query()->where("id_personal_code", "=", $personal->id)->get();

        $users->load("user");

        return $this->success("Listando todos os usuarios desse personal", $users, 200);
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        $user->load("personal");

        $personalUsers = $this->personalUsersModel::create([
            "id_user" => $request->all()["id_user"],
            "id_personal_code" => $user->personal->id
        ]);

        return $this->success("Usuario vinculado ao personal com sucesso", $personalUsers, 200);
    }
}
