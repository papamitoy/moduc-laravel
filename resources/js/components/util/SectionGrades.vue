<template>
  <div class="white_box_tittle list_header mb-2">
    <h4>{{ title }}</h4>
    <div class="box_right d-flex lms_block" id="print_hidden">
      <div class="serach_field_2">
        <div class="search_inner">
          <!-- <form Active="#">
                <div class="search_field">
                  <input type="text" placeholder="Search content here...">
                </div>
                <button type="submit"> <i class="ti-search"></i> </button>
              </form> -->
        </div>
      </div>
      <div class="add_button ml-10">
        <a href="#" class="btn_1" v-print="printObj">Print</a>
      </div>
    </div>
  </div>
  <div id="grades_table">
    <div class="">
      <div class="box_header m-0 mb-4">
        <div class="main-title">
          <h3 class="m-0"> {{ subject.subject_name }} | Grades</h3>
        </div>
      </div>
    </div>
    <div class="QA_section">

      <div class="QA_table mb_30">
        <!-- table-responsive -->
        <table class="table-bordered">
          <thead>
            <tr>
              <th rowspan="2" style="width: 400px; text-align: center;">Student Name</th>
              <th :colspan="assessments.length+3" style=" text-align: center; "><strong>SELF-ASSESSMENTS/ACTIVITIES</strong></th>
              <th v-if="title == 'Midterm'" colspan="3" style=" text-align: center;width: 150px;"><strong>PRELIM EXAM</strong></th>
              <th v-else colspan="3" style=" text-align: center;width: 150px;"><strong>SEMI-FINAL EXAM</strong></th>
              <th v-if="title == 'Midterm'" colspan="3" style=" text-align: center; width: 150px;"><strong>MIDTERM EXAM</strong></th>
              <th v-else colspan="3" style=" text-align: center; width: 150px;"><strong>FINAL EXAM</strong></th>
              <th rowspan="3" style=" text-align: center; width: 150px;">Average Exam</th>
              <th rowspan="3" style=" text-align: center;">Remarks</th>
            </tr>
            <tr style=" text-align: center;">
              <th style="text-align: center;" scope="col" v-for="(count,i) in assessments" :key="count">A{{ i+1 }}</th>

              <th style="text-align: center;" scope="col">TOTAL</th>
              <th style="text-align: center;" scope="col" rowspan="2">AVE</th>
              <th style="text-align: center;" scope="col">TRANS</th>

              <th style="text-align: center;" scope="col" rowspan="2">RAW SCORE</th>
              <th style="text-align: center;" scope="col">TRANS</th>
              <th style="text-align: center;" scope="col" rowspan="2">RATING</th>
              <th style="text-align: center;" scope="col" rowspan="2">RAW SCORE</th>
              <th style="text-align: center;" scope="col">TRANS</th>
              <th style="text-align: center;" scope="col" rowspan="2">RATING</th>
            </tr>
            <tr class="text-center">
              <th></th>
              <th v-for="count in assessments" :key="count"><strong>{{ count.max_score }}</strong></th>
              <th><strong>{{ (this.assessments.length * 10) }}</strong></th>
              <th><strong>60%</strong></th>
              <th style="width: 100px; text-align: center;"><strong>50</strong></th>
              <th style="width: 100px; text-align: center;"><strong>100</strong></th>

            </tr>
          </thead>

          <tbody>

            <tr v-for="enroll in subject.enroll" :key="enroll.id">
              <th scope="row">{{ enroll.student.fullname }}</th>
              <td style="text-align: center;" v-for="(assessment) in assessments" :key="assessment.id">
                <a style="color:black" :href="`/subject/${subject.id}/assessment/check-response?assessment_id=${assessment.id}&user_id=${enroll.student.id}`" target="_blank" v-if="assessment.response.find(res=>res.user_id == enroll.student.id) ">{{ Object.values(assessment.response.find(res=>res.user_id == enroll.student.id).score ? JSON.parse((assessment.response.find(res=>res.user_id == enroll.student.id).score)): {score:0}).reduce((total,item)=>total+Number(item),0) }}</a>
              </td>
              <td style="text-align: center;">
                <p>{{ getTotal(enroll.student.id) }}</p>
              </td>
              <td style="text-align: center;">
                <p>{{ getAverage(enroll.student.id) }}</p>
              </td>
              <td style="text-align: center;">
                <p>{{ getEqui(getAverage(enroll.student.id)) }} </p>
              </td>
              <td style="text-align: center;">
                <p v-if="title == 'Midterm'">
                  <a v-if="getAssessmentFromExam('prelim',enroll.student.id) " style="color:black" :href="`/subject/${subject.id}/assessment/check-response?assessment_id=${getAssessmentFromExam('prelim',enroll.student.id)}&user_id=${enroll.student.id}`" target="_blank">{{ getTotalExams("prelim",enroll.student.id) }}</a>
                </p>
                <p v-else>

                  <a v-if="getAssessmentFromExam('semifi',enroll.student.id) " style="color:black" :href="`/subject/${subject.id}/assessment/check-response?assessment_id=${getAssessmentFromExam('semifi',enroll.student.id)}&user_id=${enroll.student.id}`" target="_blank">{{ getTotalExams("semifi",enroll.student.id) }}</a>
                </p>

              </td>
              <td style="text-align: center;">
                <p v-if="title == 'Midterm'">{{ getTransExam(getTotalExams("prelim",enroll.student.id)) }}</p>
                <p v-else>{{ getTransExam(getTotalExams("semifi",enroll.student.id)) }}</p>
              </td>
              <td style="text-align: center;">
                <p v-if="title == 'Midterm'">{{ getEqui(getTransExam(getTotalExams("prelim",enroll.student.id))) }}</p>
                <p v-else>{{ getEqui(getTransExam(getTotalExams("semifi",enroll.student.id))) }}</p>
              </td>
              <td style="text-align: center;">
                <p v-if="title == 'Midterm'">
                  <a v-if="getAssessmentFromExam('midterm',enroll.student.id) " style="color:black" :href="`/subject/${subject.id}/assessment/check-response?assessment_id=${getAssessmentFromExam('midterm',enroll.student.id)}&user_id=${enroll.student.id}`" target="_blank">{{ getTotalExams("midterm",enroll.student.id) }}</a>
                </p>
                <p v-else>
                  <a v-if="getAssessmentFromExam('final',enroll.student.id)" style="color:black" :href="`/subject/${subject.id}/assessment/check-response?assessment_id=${getAssessmentFromExam('final',enroll.student.id)}&user_id=${enroll.student.id}`" target="_blank">{{ getTotalExams("final",enroll.student.id) }}</a>

                </p>

              </td>
              <td style="text-align: center;">
                <p v-if="title == 'Midterm'">{{ getTransExam(getTotalExams("midterm",enroll.student.id)) }}</p>
                <p v-else>{{ getTransExam(getTotalExams("final",enroll.student.id)) }}</p>
              </td>
              <td style="text-align: center;">
                <p v-if="title == 'Midterm'">{{ getEqui(getTransExam(getTotalExams("midterm",enroll.student.id))) }}</p>
                <p v-else>{{ getEqui(getTransExam(getTotalExams("final",enroll.student.id))) }}</p>
              </td>
              <td style="text-align: center;">
                <p v-if="title == 'Midterm'">{{ (getEqui(getTransExam(getTotalExams("prelim",enroll.student.id))) + getEqui(getTransExam(getTotalExams("midterm",enroll.student.id))))/2 }}</p>
                <p v-else>{{ (getEqui(getTransExam(getTotalExams("semifi",enroll.student.id))) + getEqui(getTransExam(getTotalExams("final",enroll.student.id)))) /2 }}</p>
              </td>
              <td style="text-align: center;">
                <p ref="gradeRemarks" v-if="title == 'Midterm'">{{getFinalGrades(enroll.student.id,getEqui(getAverage(enroll.student.id)),(getEqui(getTransExam(getTotalExams("prelim",enroll.student.id))) + getEqui(getTransExam(getTotalExams("midterm",enroll.student.id))))/2)}}</p>
                <p ref="gradeRemarks" v-else>{{getFinalGrades(enroll.student.id,getEqui(getAverage(enroll.student.id)),(getEqui(getTransExam(getTotalExams("semifi",enroll.student.id))) + getEqui(getTransExam(getTotalExams("final",enroll.student.id)))) /2)}}</p>
              </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import equivalence from "../../helpers";
export default {
  props: ["title", "subject", "module_section"],
  data() {
    return {
      dataInput: [],
      printObj: {
        id: "grades_table",

        beforeOpenCallback(vue) {
          const ele = document.getElementById("print_hidden");
          if (ele) ele.style.opacity = "0";
        },
        closeCallback(vue) {
          const ele = document.getElementById("print_hidden");
          if (ele) ele.style.opacity = "1";
        },
      },
    };
  },
  mounted() {
    console.log(this.$refs.gradeRemarks);
  },

  computed: {
    assessmentCount() {
      return this.subject.assessments.filter(
        (assessment) => assessment.published
      ).length;
    },
    assessments() {
      return this.subject.assessments.filter((assessment) => {
        let checkFilter =
          this.title == "Midterm"
            ? assessment.module_section.title == "Prelim" ||
              assessment.module_section.title == "Midterm"
            : assessment.module_section.title == "Semi-final" ||
              assessment.module_section.title == "Final";
        return assessment.published && assessment.type != "exam" && checkFilter;
      });
    },
    exams() {
      return this.subject.assessments.filter((assessment) => {
        let checkFilter =
          this.title == "Midterm"
            ? assessment.module_section.title == "Prelim" ||
              assessment.module_section.title == "Midterm"
            : assessment.module_section.title == "Semi-final" ||
              assessment.module_section.title == "Final";
        return assessment.published && assessment.type == "exam" && checkFilter;
      });
    },
  },
  methods: {
    getFinalGrades(user_id, grade1, grade2) {
      const grade = grade1 * 0.6 + grade2 * 0.4;

      axios
        .post(`/subject/${this.subject.id}/save-grades`, {
          subject_id: this.subject.id,
          user_id,
          grade,
          remarks: grade <= 3 ? "pass" : "fail",
          module_section: this.title,
        })
        .then(() => {})
        .catch(() => {});

      console.log("SAVE", grade);
      return grade;
    },
    getTransExam(total) {
      return (total / 50) * 100;
    },
    getEqui(ave) {
      return equivalence[ave];
    },
    getAssessmentFromExam(type, id) {
      const filterExam = this.exams.filter((exam) => exam.exam_type == type);
      if (!filterExam) return false;
      const exam = filterExam.find((exam) => {
        return exam.response.find((i) => i.user_id == id);
      });

      let response = exam ? exam.response : 0;
      response = response != 0 ? response.find((i) => i.user_id == id) : 0;
      console.log("exam filter ", type, response);
      return response.assessment_id;
    },
    getTotalExams(type, id) {
      const filterExam = this.exams.filter((exam) => exam.exam_type == type);
      return filterExam
        ? filterExam
            .map((response) => {
              return response.response.find((i) => i.user_id == id);
            })
            .reduce(
              (total, item) =>
                item
                  ? total +
                    Object.values(
                      !!item.score ? JSON.parse(item.score) : { score: 0 }
                    ).reduce((t, i) => t + Number(i), 0)
                  : total,
              0
            )
        : 0;
    },
    getTotal(id) {
      const score = Object.values(
        this.assessments
          .filter((item) => !!item.response.find((i) => i.user_id == id))
          .map((item) => {
            return item.response.find((i) => i.user_id == id).score
              ? JSON.parse(item.response.find((i) => i.user_id == id).score)
              : 0;
          })
      ).reduce((total, item) => total + Number(Object.values(item)), 0);

      return score;
    },
    getAverage(id) {
      const total = this.getTotal(id);
      const ave = Math.ceil(
        (total /
          this.assessments.reduce(
            (total, item) => total + Number(item.max_score),
            0
          )) *
          100
      );
      return ave ? ave : 0;
    },

    saveScore(subject_id, user_id, position) {
      axios
        .post(`/subject/${this.subject.id}/save-grades`, {
          subject_id,
          user_id,
          grade: this.dataInput[`${user_id}-${position}`],
          position,
        })
        .then((res) => console.log(res));
    },
    getTotalScore(assessment, id) {
      let hasScore =
        Array.from(this.getAssessmentScore(assessment, id)).length > 0;
      if (hasScore) {
        return Object.values(
          JSON.parse(this.getAssessmentScore(assessment, id)[0].score)
        ).reduce((cscore, score) => {
          return cscore + Number(score);
        }, 0);
      }
      return 0;
    },
    getAssessmentScore(assessment, id) {
      return assessment.filter((ass) => ass.assessment_id == id);
    },
  },
};
</script>

<style scoped>
.QA_section .QA_table th,
.QA_section .QA_table td {
  padding: 5px;
}
</style>
