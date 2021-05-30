<?php


namespace App\Models;


class Student extends BaseModel {

	public function table(): string {
		return 'students';
	}

	public function getInfoById( int $id ): array {
		$this->SelectWhat( array(
			                   'student_id'    => 'students.id',
			                   'group_id'      => 'GR.id',
			                   'department_id' => 'DEP.id',
			                   'faculty_id'    => 'FA.id',
		                   ) )
		     ->simpleJoin( "
		     JOIN `groups` GR ON GR.id = `students`.group_id
		     JOIN `departments` DEP ON DEP.id = GR.`department_id`
		     JOIN `faculties` FA ON FA.id = DEP.faculty_id
		     " )
		     ->WhereEqually( 'students.id', $id );


		return $this->Get()->one();
	}

}