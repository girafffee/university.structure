<template>
	<section class="container">
		<section class="mt-3 mb-3">
			<b-table striped hover :items="students" :fields="studentFields"></b-table>
		</section>
		<b-sidebar id="event-sidebar" title="Title" shadow backdrop>
			<div class="px-3 py-2">
			</div>
		</b-sidebar>
	</section>
</template>

<script>
import RemoteMixin from "../../mixins/RemoteMixin";
import { BSidebar, BListGroup, BListGroupItem, BTable } from 'bootstrap-vue';

export default {
	name: "App",
	components: { BSidebar, BListGroup, BListGroupItem, BTable },
	data() {
		return {
			students: this.config( 'students' ),
			studentFields: [
				'first_name',
				'last_name',
				'middle_name',
				'group_title',
				'department_title'
			],
		};
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
