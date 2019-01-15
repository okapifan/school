<?php

require_once('Controller.php');
require_once('../model/User.php');

class UserController extends Controller {

    /**
     * method index
     * The index function, shows all users in a file
     */
    function index() {
        $users = User::all();
        foreach ($users AS $u) {
            if (!empty($u->user_educations())) {
                $u->education = $u->user_educations()->educations()->name;
            } else {
                $u->education = null;
            }
        }

        $this->showTemplate('user.index', compact('users'));
    }

    /**
     * method edit
     * Shows edit page for a user
     */
    function edit() {
        $id = $_REQUEST['id'];
        $user = User::find($id);
        $userEducation = $user->user_educations();
        if (!empty($userEducation))
            $userEducation = $userEducation->educations();

        $educations = Education::all();
        $groups = [1,2,3,4,5,6,7,8];
        $this->showTemplate('user.edit', compact('user', 'educations', 'groups', 'userEducation'));
    }

    /**
     * method store
     * Post after edit to store/ change user data
     */
    function update() {
        if (!isset($_REQUEST['id']))
            die('For the store function, the ID should exist');

        $id = $_REQUEST['id'];
        $user = User::find($id);
        $data = $_POST;

        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->class = $data['class'];
        $user->date_of_birth = $data['date_of_birth'];

        $user->save();

        $ue = $user->user_educations();
        if (empty($ue)) {
            $ue = new UserEducation();
            $ue->user_id = $id;
        }

        $ue->education_id = $data['education'];
        $ue->save();

        StoreMessage(['success', 'Gebruiker met succes opgeslagen']);
        return Redirect('/?page=user');
    }
}