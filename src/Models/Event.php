<?php


namespace App\Models;


class Event extends BaseModel {

	public function table(): string {
		return 'events';
	}

	public function getEventsByStudentId( int $id ): array {
		$this->SelectWhat( array(
			                   'id'            => 'events.id',
			                   'order'         => 'CO.title',
			                   'time_begin'    => 'CO.time_begin',
			                   'time_end'      => 'CO.time_end',
			                   'subject'       => 'ACS.title',
			                   'subject_short' => 'ACS.short',
			                   'event_type'    => 'ET.title',
			                   'date'          => 'events.date',
			                   'audience'      => 'AU.title',
			                   'staff'         => 'GROUP_CONCAT(
			                   CONCAT_WS( " ", 
			                        SF.last_name, 
			                        CONCAT( SUBSTR( SF.first_name, 1, 1 ), "." ), 
			                        CONCAT( SUBSTR( SF.middle_name, 1, 1 ), "." ) 
			                   ) 
		)'
		                   ) )
		     ->simpleJoin( "
			JOIN classes_orders CO ON CO.id = events.class_order_id
			JOIN academic_subjects ACS ON ACS.id = events.academic_subject_id  
			JOIN event_types ET ON ET.id = events.event_type_id
			JOIN audiences AU ON AU.id = events.audience_id
			JOIN staff_on_event STEV ON STEV.event_id = events.id
			JOIN groups_on_event GOEV ON GOEV.event_id = events.id 
			JOIN students ST ON GOEV.group_id = ST.group_id AND ST.id = {$id}
			JOIN staff SF ON SF.id = STEV.staff_id
		" )
		     ->WhereAnd( 'GOEV.group_id', '=', 'ST.group_id' )
		     ->GroupBy( 'GOEV.event_id' )
		     ->OrderBy( 'events.date ASC, CO.time_begin ASC' );


		return array_map( array( $this, 'prepareEvent' ), $this->Get()->all() );
	}

	protected function prepareEvent( $event ): array {
		$event['start'] = "{$event['date']}T{$event['time_begin']}";
		$event['end']   = "{$event['date']}T{$event['time_end']}";
		$event['title'] = $event['subject'];

		return $event;
	}
}