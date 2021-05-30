<?php


namespace App\Controllers;

use App\Layouts\FooterLayoutPart;
use App\Layouts\HeadLayoutPart;
use App\Models\Department;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\Student;

class StudentScheduleController extends BaseController {

	public function actionIndex(): string {
		$this->setInitialData();

		return $this->render( 'schedule/student.php' );
	}

	public function actionView( $action, $id ) {
		$event   = new Event();
		$student = new Student();

		$this->setInitialData(
			array_merge(
				array( 'events' => $event->getEventsByStudentId( (int) $id ) ),
				$student->getInfoById( $id )
			)
		);

		return $this->render( 'schedule/student.php' );
	}

	public function setInitialData( $additional = array() ) {
		$faculty    = new Faculty();
		$department = new Department();
		$group      = new Group();
		$student    = new Student();

		HeadLayoutPart::get()->registerJsVar(
			'pageConfig',
			array_merge( array(
				             'faculties'     => $faculty->getAll(),
				             'departments'   => $department->getAll(),
				             'groups'        => $group->getAll(),
				             'students'      => $student->getAll(),
				             'student_id'    => 0,
				             'faculty_id'    => 0,
				             'department_id' => 0,
				             'group_id'      => 0,
				             'events'        => array(),
			             ), $additional )
		);

		FooterLayoutPart::get()->registerJs( '%assets%/js/schedule/student.bundle.js' );
	}
}