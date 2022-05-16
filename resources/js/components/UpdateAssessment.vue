<template>

  <div class="col-md-8 col-lg-8 col-xl-6 box-col-8">
    <div class="col-lg-12">
      <h4 style="opacity: .7;" class="color_pink">Preview</h4>
      <div class="card_box box_shadow position-relative mb_30">
        <div class="white_box_tittle ">
          <div class="main-title2 ">
            <!-- to be design start -->

            <div class="form-group mb-0 mt-2">
              <label for="inputState">Questionnaire Type</label>
              <input readonly type="text" class="form-control mb-2" :value="getAssessmentType" v-if="getAssessmentType">

              <input readonly :value="getExamType" type="text" class="form-control" v-if="assessmentType == 'exam' && getExamType">
            </div>
            <!-- to be design end-->

            <h2 class="mb-2 nowrap mt-4">{{ title }}</h2>
            <p>{{ description }}</p>
          </div>
        </div>
        <div class="box_body">
          <!-- lol  -->
          <div class="default-according" id="accordion1">
            <div v-for="(question,index) in questions" :key="question.question">
              <Essay :number="index+1" v-if="question.type == 'essay'" :question="question" />
              <MultipleChoice :number="index+1" v-else-if="question.type == 'multiple-choice'" :question="question" />
              <ShortAnswer :number="index+1" v-else-if="question.type=='short-answer'" :question="question" />
            </div>
            <nav aria-label=" Page navigation example">
              <!-- <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li>
              </ul> -->
            </nav>
          </div>
          <!-- lol  -->

        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 col-lg-4 col-xl-6 box-col-4 ">
    <h4 style="opacity: .7;" class="color_pink">Assesment Info</h4>
    <div style="background-color: #FBF6F0;" class="white_card mb_30 card_box box_shadow">
      <div class="white_card_header">
      </div>
      <div class="white_card_body">
        <div class="card-body">
          <div class="form-group">
            <label for="inputAddress">Form Title</label>
            <input readonly :value="title" type="text" class="form-control" id="inputAddress" style="font-size: 25px;">
          </div>
          <div class="form-group">
            <label for="inputAddress">Form Description</label>
            <input readonly :value="description" type="text" class="form-control" id="inputAddress" style="font-size: 15px;">
          </div>
          <div class="form-group mb-0">
            <label for="date">Due Date : {{getDate(deadline,"lll")}}</label>
            <input v-model="deadline" type="datetime-local" :min="`${new Date()}`" class=" form-control" name="inputDate" id="inputDate">
          </div>
          <div class="row mt-3">
            <div class="col-md-6">
              <div class="form-group mb-0">
                <input v-model="hasTimeLimit" :checked="hasTimeLimit == 1" type="checkbox">
                <label class="ml-2" for="timelimit">Enable Time Limit</label>
              </div>
              <div v-if="hasTimeLimit" class="form-group mb-0">
                <input class="form-control" placeholder="Enter time limit in minutes" type="number" v-model="timeLimit">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-0">
                <input v-model="publish" :checked="publish == 1" type="checkbox" name="inputDate" id="publish">
                <label class="ml-2" for="publish">Publish</label>
              </div>
            </div>

          </div>
          <div style="display:flex;justify-content:space-between">
            <a :href="`/assessments/update?id=${assessment.main_assessment_id}&redirect=${subject.id}`" class="btn btn-primary mt-5">Update Main Questionnaire</a>
            <button class="btn btn-primary mt-5" @click="save()">Save</button>
          </div>
        </div>

      </div>
    </div>
  </div>

</template>

<script>
import moment from "moment";
import Essay from "./util/Essay.vue";
import MultipleChoice from "./util/MultipleChoice.vue";
import ShortAnswer from "./util/ShortAnswer.vue";
export default {
  props: ["subject", "section", "assessment"],
  components: {
    Essay,
    MultipleChoice,
    ShortAnswer,
  },
  computed: {
    getExamType() {
      switch (this.examType) {
        case "prelim":
          return "Prelim";
        case "midterm":
          return "Midterm";
        case "semifi":
          return "Semi-Final";
        case "final":
          return "Final";
      }
      return null;
    },
    getAssessmentType() {
      switch (this.assessmentType) {
        case "exam":
          return "Major Exam";
        case "assessment":
          return "Assessment";
        case "activity":
          return "Activity";
      }
      return null;
    },
    uploadZoneUrl() {
      return `/api/update-file-assessment?id=${
        this.selectedId ? this.selectedId : ""
      }`;
    },
  },
  mounted() {
    this.selectedId = this.assessment.id;
    this.questions =
      this.assessment && this.assessment.questions
        ? JSON.parse(this.assessment.questions)
        : [];
    this.description = this.assessment.description;
    this.deadline = this.assessment.deadline;
    this.shuffle = this.assessment.shuffle == 1;
    this.title = this.assessment.title;
    this.published = this.assessment.published;
    this.assessmentType = this.assessment.type;
    this.examType = this.assessment.exam_type;
    this.hasTimeLimit = this.assessment.has_time_limit;
    this.timeLimit = this.assessment.time_limit;
    this.publish = this.assessment.published;
  },
  data() {
    return {
      selectedId: null,
      title: "Untitled Form",
      description: "",
      questionType: "e",
      questions: [],
      deadline: null,
      assessmentType: "exam",
      shuffle: false,
      published: false,
      examType: "prelim",
      hasTimeLimit: false,
      timeLimit: 0,
      publish: false,
    };
  },
  methods: {
    getDate(date, format) {
      return moment(date).format(format);
    },
    save() {
      this.saveAssessment();
    },
    saveAssessment() {
      let that = this;

      axios
        .post("/api/class/create/assessment", {
          id: this.subject.id,
          questions: this.questions,
          module_section_id: this.section.id,
          title: this.title,
          description: this.description,
          deadline: this.deadline,
          assessmentType: this.assessmentType,
          shuffle: this.shuffle,
          selectedId: this.selectedId,
          examType: this.examType,
          hasTimeLimit: this.hasTimeLimit,
          timeLimit: this.timeLimit,
          publish: this.publish,
        })
        .then((res) => {
          console.log(res);
          if (res.data.success) {
            that.selectedId = res.data.data.id;
            if (res.data.success) {
              this.$Swal
                .fire("Success", "Saved successfully", "success")
                .then(() => (location.href = "/subject/" + this.subject.id));
            }
            if (res.data.reload) {
              var url = new URL(location.href);
              //   url.searchParams.set("id", res.data.data.id);
              location.href = url;
            }
          }
        })
        .catch((err) => {
          conosle.log(err);
          return;
          this.$Swal
            .fire("Warning", "An error occur please try again later", "warning")
            .then(() => {
              location.reload();
            });
        });
    },
  },
};
</script>

<style scoped>
.dropzone.dropzone__box.dropzone-clickable {
  width: 100%;
}
</style>
