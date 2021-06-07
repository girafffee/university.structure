<?php


namespace App\Controllers;


use App\Layouts\FooterLayoutPart;
use App\Layouts\HeadLayoutPart;
use App\Models\Student;

class StudentListController extends BaseController {

	public function actionIndex() {
		$students = ( new Student() )
			->getAllWithTables( array(
				                    'first_name'       => 'students.first_name',
				                    'last_name'        => 'students.last_name',
				                    'middle_name'      => 'students.middle_name',
				                    'group_title'      => 'GR.display_name',
				                    'department_title' => 'DEP.title'
			                    ) );

		HeadLayoutPart::get()->registerJsVar( 'pageConfig', array(
			'students' => $students
		) );

		FooterLayoutPart::get()->registerJs( '%assets%/js/lists/student.bundle.js' );

		return $this->render( 'lists/student.php' );
	}

}