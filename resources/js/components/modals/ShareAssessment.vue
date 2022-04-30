<template>
  <!-- modal popup -->
  <div class="modal fade" id="shareAssessment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Send this assessment to a subject</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="flex">
          <div class="px-2 py-3" style="border-right:1px solid #ddd">
            <div>Subject List</div>
            <div>
              <div :class="`${selected_subject && selected_subject.id == subject.id && 'selected-subject'} subject-list  my-1`" v-for="(subject,i) in subjects" :key="i" @click="selectSubject(subject)">
                {{subject.subject_name}}
              </div>
            </div>
          </div>
          <form action="/api/class/create" method="post" style="flex:1">

            <div class="modal-body" v-if="selected_subject">

              <div class="form-group" v-if="selected_subject">
                <label for="exampleInputEmail1">Subject Name</label>
                <input :value="selected_subject.subject_name" readonly required type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              </div>
              <div v-else class="form-group">
                <label for="exampleInputEmail1">Please select a subject</label>
              </div>

              <div class="row" v-if="selected_subject">
                <div class="col-xl-6">
                  <div class="form-group boxsection" @click="selectSection('Prelim')">
                    <input :checked="selected_section == 'Prelim'" id="prelim" name="section_type" type="radio">
                    <label @click.stop for="prelim">Prelim</label>
                  </div>
                  <div class="form-group boxsection" @click="selectSection('Midterm')">
                    <input :checked="selected_section == 'Midterm'" id="midterm" name="section_type" type="radio">
                    <label @click.stop for="midterm">Midterm</label>
                  </div>
                </div>
                <div class="col-xl-6">
                  <div class="form-group boxsection" @click="selectSection('Semi-final')">
                    <input :checked="selected_section == 'Semi-final'" id="Semi-final" name="section_type" type="radio">
                    <label @click.stop for="Semi-final">Final</label>
                  </div>
                  <div class="form-group boxsection" @click="selectSection('Final')">
                    <input :checked="selected_section == 'Final'" id="Final" name="section_type" type="radio">
                    <label @click.stop for="Final">Final</label>
                  </div>
                </div>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" @click="sendAssessment">Send</button>
        </div>
      </div>
    </div>
  </div>
  <!-- end modal popup -->

</template>

<script>
export default {
  props: ["subjects", "assessment"],
  data: () => ({
    selected_section: null,
    selected_subject: null,
    error_message: "",
  }),
  methods: {
    selectSection(section) {
      this.selected_section = section;
    },
    selectSubject(subject) {
      this.selected_subject = subject;
    },

    async sendAssessment() {
      if (!this.selected_section)
        return (this.error_message = "Please select a section to send");
      if (!this.selected_subject)
        return (this.error_message = "Please select a subject to send");

      try {
        const response = await axios.post("/api/assessment/send", {
          selected_section: this.selected_section,
          selected_subject: this.selected_subject,
          assessment_id: this.assessment.id,
        });
        if (response.data.success) {
          return this.$Swal.fire("Success", "Added successfully", "success");
        } else {
          return this.$Swal.fire("Warning", response.data.message, "warning");
        }
      } catch (err) {
        console.log(err);
      }
      return this.$Swal.fire(
        "Warning",
        "Please try again later or refresh the page",
        "warning"
      );
    },
  },
};
</script>

<style scoped>
.selected-subject {
  background: #00ead3;
}
.subject-list {
  border: 1px solid #aaa;
  border-radius: 4px;
  padding: 10px;
  cursor: pointer;
  font-weight: bold;
  min-width: 150px;
}
.boxsection {
  border: 1px solid #aaa;
  border-radius: 10px;
  padding: 10px;
  cursor: pointer;
  font-weight: bold;
}
.boxsection input {
  margin-right: 10px;
}
.flex {
  display: flex;
}
#shareAssessment .modal-content {
  z-index: 1000 !important;
}
</style>
