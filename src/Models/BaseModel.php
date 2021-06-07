<?php


namespace App\Models;


use App\DB\PDO_DB;

abstract class BaseModel {

	public $alias;

	public $simpleJoin;

	public $sql; // Содержит запрос
	public $Select;
	public $Where;
	public $WhereAnd;
	public $WhereOr;
	public $WhereLike;
	public $having;

	public $Order;
	public $Group;
	public $Lim;
	public $Pag;

	public $addFields;
	public $findField;


	abstract public function table(): string;

	public function simpleJoin( $join ): BaseModel {
		$this->simpleJoin .= $join;

		return $this;
	}

	public function WhereEqually( $f, $s ): BaseModel {
		$this->Where = $f . "='" . $s . "' ";

		return $this;
	}

	public function OrderBy( $o ): BaseModel {
		$this->Order = " ORDER BY " . $o . " ";

		return $this;
	}

	public function GroupBy( $o ): BaseModel {
		$this->Group = " GROUP BY " . $o . " ";

		return $this;
	}

	// id, < , 2
	public function WhereAnd( $f, $o, $s ): BaseModel {
		$this->WhereAnd[] = $f . $o . $s;

		return $this;
	}


	public function SelectWhat( $array_selected ): BaseModel {
		$selected = array();
		foreach ( $array_selected as $name => $item ) {
			$selected[] = $item . " as " . "'$name'";
		}
		$this->Select = implode( ", ", $selected );

		return $this;
	}

	public function Get( $multiple = true ) {
		$sql = "SELECT ";
		if ( strlen( $this->Select ) > 0 ) {
			$sql .= $this->Select;
		} else {
			$sql .= " * ";
		}

		$sql .= " FROM " . $this->table();
		$sql .= $this->simpleJoin;

		$flagWhere = " WHERE ";

		if ( strlen( $this->Where ) > 0 ) {
			$sql       .= $flagWhere . $this->Where;
			$flagWhere = " ";
		}
		if ( is_array( $this->WhereLike ) ) {
			if ( strlen( $this->Where ) > 0 ) {
				$sql .= " AND ";
			}
			$sql       .= $flagWhere;
			$flagWhere = " ";

			$where_groups = [];
			foreach ( $this->WhereLike as $column => $conditions ) {
				$where_groups[ $column ] = ' (' . implode( ' OR ', $conditions ) . ') ';
			}
			$sql .= implode( "\n AND \n", $where_groups );
		} else {
			/*if(strlen($this->WhereLike) > 0 || strlen($this->Where) > 0)
				$flagWhere = " WHERE ";
			else
				$flagWhere = " ";*/

			if ( is_array( $this->WhereAnd ) ) {
				$sql       .= $flagWhere . '(' . implode( ") AND (", $this->WhereAnd ) . ')';
				$flagWhere = "";
			}
			if ( is_array( $this->WhereOr ) ) {
				if ( strlen( $flagWhere ) == 0 ) {
					$sql .= " OR ";
				}
				$sql       .= $flagWhere . '(' . implode( ") OR (", $this->WhereOr ) . ')';
				$flagWhere = "";
			}
		}
		if ( strlen( $this->Group ) ) {
			$sql .= $this->Group;
		}
		/** having
		 * [
		 * 'genres_id' =>
		 * [
		 *      ...
		 * ]
		 * ]
		 * */

		if ( is_array( $this->having ) ) {
			$sql           .= " HAVING ";
			$having_groups = [];
			foreach ( $this->having as $column => $conditions ) {
				$having_groups[ $column ] = ' (' . implode( ' OR ', $conditions ) . ') ';
			}
			$sql .= implode( "\n AND \n", $having_groups );

		}
		if ( strlen( $this->Order ) > 0 ) {
			$sql .= $this->Order;
		}
		if ( strlen( $this->Pag ) > 0 ) {
			$sql .= $this->Pag;
		} elseif ( strlen( $this->Lim ) > 0 ) {
			$sql .= $this->Lim;
		}
		$sql .= "; ";

		//echo "<pre><p> sql: " . $sql . "</p>"; die();

		$this->sql = $sql;

		return $this;
	}

	public function all(): array {
		return $this->querySql( 'fetchAll', \PDO::FETCH_ASSOC );
	}

	public function one(): array {
		return $this->querySql( 'fetch', \PDO::FETCH_ASSOC );
	}

	public function querySql( $funcName, $mode ): array {
		if ( empty( $this->sql ) ) {
			return array();
		}

		//var_dump( $this->sql ); die;

		$query = PDO_DB::instance()->query( $this->sql );
		if ( $query ) {
			return call_user_func( array( $query, $funcName ), $mode );
		}

		return array();
	}

	public function Create( $data ): PDO_DB {
		$sql = "INSERT INTO " . $this->table() . " ( ";
		for ( $i = 0; $i < sizeof( $this->addFields ); $i ++ ) {
			$arrFilds[] = "`" . $this->addFields[ $i ] . "`";
		}
		$sql .= implode( ", ", $arrFilds );
		$sql .= ") VALUES (";

		for ( $i = 0; $i < sizeof( $this->addFields ); $i ++ ) {
			if ( array_key_exists( $this->addFields[ $i ], $data ) ) {
				$arrValues[] = $data[ $this->addFields[ $i ] ];
			} else {
				$arrValues[] = $data[ $this->alias . '.' . $this->addFields[ $i ] ];
			}
		}
		$sql .= ':' . implode( ", :", $this->addFields );
		$sql .= '); ';

		//echo $sql; print_r($data); die();
		$query = PDO_DB::instance()->prepare( $sql );

		return $query->exec( $data );
	}

	public function Delete( $data ): void {
		$sql = "DELETE FROM " . $this->table() . " WHERE ";
		foreach ( $data as $col => $value ) {
			$conditions[] = $col . ' = :' . $col;
		}
		$sql .= implode( ' AND ', $conditions );
		$sql .= ';';

		//echo $sql; die();
		$query = PDO_DB::instance()->prepare( $sql );
		$query->exec( $data );
	}

	public function Update( $data ): void {
		$sql = "UPDATE " . $this->table() . " SET ";
		foreach ( $data as $col => $value ) {
			if ( $col != $this->findField ) {
				$newValues[] = $col . "=:" . $col;
			}

		}
		$sql .= implode( ", ", $newValues );
		$sql .= " WHERE " . $this->findField . '=' . $data[ $this->findField ];
		unset( $data[ $this->findField ] );
		$sql .= '; ';

		//echo $sql;
		$query = PDO_DB::instance()->prepare( $sql );
		//print_r($sql); print_r($data);
		$query->exec( $data );
	}



	public function getAll(): array {
		$sql = "SELECT * FROM `" . $this->table() . '`;';

		return PDO_DB::instance()->query( $sql )->fetchAll( \PDO::FETCH_ASSOC );
	}

}