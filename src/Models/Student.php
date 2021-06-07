<?php


namespace App\Models;


class Student extends BaseModel {

	public function table(): string {
		return 'students';
	}

	public function getInfoById( int $id, array $select_map = array() ): array {
		$this->withTables( $select_map )->WhereEqually( 'students.id', $id );

		return $this->Get()->one();
	}

	public function withTables( array $select_map = array() ): Student {
		return $this->SelectWhat( array_merge( array(
			                                       'student_id'    => 'students.id',
			                                       'group_id'      => 'GR.id',
			                                       'department_id' => 'DEP.id',
			                                       'faculty_id'    => 'FA.id',
		                                       ), $select_map ) )
		            ->simpleJoin( "
		     JOIN `groups` GR ON GR.id = `students`.group_id
		     JOIN `departments` DEP ON DEP.id = GR.`department_id`
		     JOIN `faculties` FA ON FA.id = DEP.faculty_id
		     " );
	}

	public function getAllWithTables( array $select_map = array() ): array {
		$this->withTables( $select_map );

		return $this->Get()->all();
	}

}