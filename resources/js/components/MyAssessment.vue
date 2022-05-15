<template>
  <div class="col-12">
    <div class="container-fluid ">
      <div class="row mb-2">
        <div class="col-lg-12">
          <a href="/assessments/create" class="btn btn-primary">Create Assessment</a>
        </div>
      </div>
      <div class="row ">
        <div class="col-xl-3" v-for="(assessment,i) in   assessmentList" :key="i">
          <div class="white_card card_height_75 mb_30 social_media_card">
            <div class="white_card_header">
              <div class="main-title">
                <h2 class="m-0">{{assessment.title}}</h2>
                <span>{{ assessment.description }}</span>
              </div>
            </div>
            <div class="media_thumb ml_25">
              <img src="img/media.svg" alt="">
            </div>
            <div class="text-center">
              <div class="card-footer bg-white">
                <div class="row">
                  <div style="margin-right: 35px;" class=" col- col-sm-4">
                    <a href="" style="font-size: 12px; color: rgb(0, 131, 218) ;">View Response</a>
                    <h3 class="counter">{{ getResponsesCount(assessment) }}</h3>
                  </div>
                  <div>
                    <button @click="selectAssessment(assessment)" type="button" class="btn btn-primary2" data-toggle="modal" data-target="#shareAssessment" style="padding-left: 10px; margin-top: 12px; margin-left: 5px; font-size: 12px;">Send to</button>
                    <a type="button" class="btn btn-info" target="_blank" :href="`/assessments/update?id=${assessment.id}`" style="padding-left: 10px; margin-top: 12px; margin-left: 5px; font-size: 12px; ">Edit</a>
                    <button @click="deleteAssessment(assessment.id)" type="button" class="btn btn-danger" data-toggle="modal" data-target="#grid_modal" style="padding-left: 10px; margin-top: 12px; margin-left: 5px; font-size: 12px; float: right;">delete</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <Teleport to="#share-assessment">
            <ShareAssessment v-if="selectedAssessment" :subjects="subjects" :assessment="selectedAssessment"></ShareAssessment>
          </Teleport>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
import ShareAssessment from "../components/modals/ShareAssessment.vue";
export default {
  props: ["mainassessments", "subjects"],
  components: { ShareAssessment },
  data: () => ({
    assessmentList: [],
    selectedAssessment: null,
  }),
  mounted() {
    this.assessmentList = this.mainassessments;
  },
  methods: {
    getResponsesCount(assessment) {
      const subject = this.subjects
        .filter((subject) =>
          subject.assessments.find((a) => a.main_assessment_id == assessment.id)
        )
        .map(
          (subject) =>
            subject.assessments.find(
              (a) => a.main_assessment_id == assessment.id
            ).response
        )
        .reduce((result, item) => result + item.length, 0);
      return subject;
    },
    selectAssessment(assessment) {
      this.selectedAssessment = assessment;
    },
    deleteAssessment(id) {
      this.$Swal
        .fire({
          title: "Do you want to remove this assessment?",
          showDenyButton: true,
          confirmButtonText: "Yes",
          denyButtonText: `No`,
          denyButtonColor: `#aaa`,
          confirmButtonColor: "#dc3545",
        })
        .then(async (result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            try {
              const data = await axios.post("/api/assessment/remove", {
                id: id,
              });
              if (data.data.success) {
                this.assessmentList = this.assessmentList.filter(
                  (assessment) => assessment.id != id
                );
                this.$Swal.fire("Removed successfully", "", "success");
                return;
              }
            } catch (e) {
              console.log(e);
            }
            this.$Swal.fire("Please try again later", "", "info");
          }
        });
    },
  },
};
</script>

<style scoped>
.swal2-styled.swal2-deny {
  color: #777;
}
</style>
