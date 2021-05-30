<template>
	<section class="container">
		<section class="mt-3 mb-3">
			<div class="row mb-3">
				<div class="col-6">
					<select class="form-select" v-model="response.faculty_id">
						<option value="0">Оберiть факультет</option>
						<option v-for="fac in faculties" :value="fac.id">{{ fac.title }}</option>
					</select>
				</div>
				<div class="col-6">
					<select class="form-select" v-model="response.department_id"
							:disabled="! Number( response.faculty_id )">
						<option value="0">Оберiть кафедру</option>
						<option v-for="dep in compDepartments" :value="dep.id">{{ dep.title }}</option>
					</select>
				</div>
				<div class="col-6">
					<select
						class="form-select"
						v-model="response.group_id"
						:disabled="! Number( response.department_id )"
					>
						<option value="0">Оберiть групу</option>
						<option v-for="group in compGroups" :value="group.id">{{ group.display_name }}</option>
					</select>
				</div>
				<div class="col-6">
					<select
						class="form-select"
						v-model="response.student_id"
						:disabled="! Number( response.group_id )"
						@change="getSchedule"
					>
						<option value="0">Оберiть студента</option>
						<option v-for="student in compStudents" :value="student.id">{{ student | formatName }}</option>
					</select>
				</div>
			</div>
		</section>
		<section v-if="calendarOptions.initialEvents.length">
			<FullCalendar :options="calendarOptions"/>
			<b-sidebar id="event-sidebar" :title="currentEvent.subject" shadow backdrop>
				<div class="px-3 py-2">
					<b-list-group>
						<b-list-group-item>Час початку: {{ currentEvent.time_begin }}</b-list-group-item>
						<b-list-group-item>Тип події: {{ currentEvent.event_type }}</b-list-group-item>
						<b-list-group-item>Дата проведення: {{ currentEvent.date }}</b-list-group-item>
						<b-list-group-item>Аудиторія: {{ currentEvent.audience }}</b-list-group-item>
						<b-list-group-item>Викладач(i): {{ currentEvent.staff }}</b-list-group-item>
					</b-list-group>
				</div>
			</b-sidebar>
		</section>
	</section>
</template>

<script>
import RemoteMixin from "../../mixins/RemoteMixin";
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import { BSidebar, BListGroup, BListGroupItem } from 'bootstrap-vue';

export default {
	name: "App",
	components: { FullCalendar, BSidebar, BListGroup, BListGroupItem },
	data() {
		return {
			response: {
				faculty_id: this.config( 'faculty_id', 0 ),
				department_id: this.config( 'department_id', 0 ),
				group_id: this.config( 'group_id', 0 ),
				student_id: this.config( 'student_id', 0 )
			},
			faculties: this.config( 'faculties' ),
			departments: this.config( 'departments' ),
			groups: this.config( 'groups' ),
			students: this.config( 'students' ),
			calendarOptions: {
				plugins: [ dayGridPlugin, interactionPlugin ],
				initialView: 'dayGridMonth',
				initialEvents: this.config( 'events', [] ),
				eventClick: this.handleEventClick,
			},
			currentEvent: {}
		};
	},
	filters: {
		formatName( value ) {
			if ( 'string' === typeof value ) {
				return value;
			}
			const response = [];

			if ( value.last_name ) {
				response.push( value.last_name );
			}
			if ( value.first_name ) {
				response.push( value.first_name );
			}
			if ( value.middle_name ) {
				response.push( value.middle_name );
			}

			return response.join( ' ' );
		}
	},
	computed: {
		compDepartments() {
			if ( !this.response.faculty_id ) {
				return this.departments;
			}
			return this.departments.filter( department => +this.response.faculty_id === +department.faculty_id );
		},
		compGroups() {
			if ( !+this.response.department_id ) {
				return this.groups;
			}
			return this.groups.filter( group => +this.response.department_id === +group.department_id );
		},
		compStudents() {
			if ( !+this.response.group_id ) {
				return this.students;
			}
			return this.students.filter( student => +this.response.group_id === +student.group_id );
		},
	},
	created() {
	},
	mixins: [ RemoteMixin ],
	methods: {
		getSchedule() {
			if ( +this.response.student_id > 0 ) {
				window.location.href = `${ this.global( 'root' ) }/schedule/student/view/${ +this.response.student_id }`;
			}
		},
		handleEventClick( clickInfo ) {
			let date = clickInfo.event.start;

			this.currentEvent = {
				...clickInfo.event.extendedProps,
				date: `${ date.getDate() }.${ date.getMonth() }.${ date.getFullYear() }`
			};
			this.$root.$emit( 'bv::toggle::collapse', 'event-sidebar' )
		}
	}
}
</script>

<style scoped>
.row.mb-3 {
	height: 100px;
}
</style>