<?php

require_once('Controller.php');
require_once('../model/Course.php');
require_once('../model/UserCourseGrade.php');
require_once('../model/User.php');

/**
 * Class HomeController
 * The controller to show the initial/ home page
 */
class GradeController extends Controller {

    var $classes = [1,2,3,4,5,6,7,8];
    /**
     * method index
     * shows the home-template (/views/grade.index.mustache)
     */
    function index() {
        $courses = Course::all();
        $classes = $this->classes;
        $this->showTemplate('grade.index', compact('classes', 'courses'));
    }

    function show() {
        $classes = $this->classes;
        $this->showTemplate('grade.show', compact('classes'));
    }

    function showclass() {
        $class = $_GET['id'];
        if (!in_array($class, $this->classes))
            die('You did not specify a legal./ existing class...');

        $courses = Course::all();
        $students = User::where([['class', '=', $class], ['role_id', '=', 1]]);

        $this->showTemplate('grade.showclass', compact('class', 'courses', 'students'));
    }

    function create() {
        $class = $_REQUEST['class'];
        $course = Course::find($_REQUEST['course']);
        $students = User::where([['class', '=', $class], ['role_id', '=', 1]]);

        $this->showTemplate('grade.create', compact('class', 'course', 'students'));
    }

    function store() {
        $data = $_POST;

        foreach ($data['student'] AS $student_id => $grade) {
            $ucg = new UserCourseGrade();
            $ucg->grade_date = $data['date'];
            $ucg->grade = $grade;
            $ucg->course_id = $data['course_id'];
            $ucg->user_id = $student_id;
            $ucg->save();

        }

        StoreMessage(['success', 'Cijfers met succes opgeslagen']);

        return Redirect('/?page=grade');
    }
}
