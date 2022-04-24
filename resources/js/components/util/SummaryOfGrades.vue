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
        <a href="#" class="btn_1" v-print="printObj"> Print</a>
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
        <table class="table-bordered" style="width:100%">
          <thead>
            <tr style="width:100%">
              <th style="width: 300px; text-align: center;">Student Name</th>
              <th style=" text-align: center;">Midterm Grade</th>
              <th style=" text-align: center;">Final Grade</th>
              <th style=" text-align: center;">Final Rating</th>
              <th style=" text-align: center;">Remarks</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="enroll in subject.enroll" :key="enroll.id">
              <td>{{enroll.student.fullname}}</td>
              <td style=" text-align: center;">{{getGrade(enroll,"Midterm").toFixed(1)}}</td>
              <td style=" text-align: center;">{{getGrade(enroll,"Final").toFixed(1)}}</td>
              <td style=" text-align: center;">{{((getGrade(enroll,"Midterm") + getGrade(enroll,"Final"))/ 2).toFixed(1)}}</td>
              <td style=" text-align: center;">{{((getGrade(enroll,"Midterm") + getGrade(enroll,"Final"))/ 2) > 3.0 ? "Failed" : "Passed"}}</td>
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
  data: () => ({
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
  }),
  computed: {},
  methods: {
    getGrade(enroll, type) {
      return this.getFinalGrades(
        this.getEqui(this.getAverage(type, enroll.student.id)),
        (this.getEqui(
          this.getTransExam(
            this.getTotalExams(
              type == "Midterm" ? "prelim" : "semifi",
              enroll.student.id
            )
          )
        ) +
          this.getEqui(
            this.getTransExam(
              this.getTotalExams(
                type == "Midterm" ? "midterm" : "final",
                enroll.student.id
              )
            )
          )) /
          2
      );
    },
    getTransExam(total) {
      return (total / 50) * 100;
    },
    getTotalExams(type, exam_type, id) {
      const filterExam = this.exams(type).filter(
        (exam) => exam.exam_type == exam_type
      );
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
    exams(type) {
      return this.subject.assessments.filter((assessment) => {
        let checkFilter =
          type == "Midterm"
            ? assessment.module_section.title == "Prelim" ||
              assessment.module_section.title == "Midterm"
            : assessment.module_section.title == "Semi-final" ||
              assessment.module_section.title == "Final";
        return assessment.published && assessment.type == "exam" && checkFilter;
      });
    },
    assessments(type) {
      return this.subject.assessments.filter((assessment) => {
        let checkFilter =
          type == "Midterm"
            ? assessment.module_section.title == "Prelim" ||
              assessment.module_section.title == "Midterm"
            : assessment.module_section.title == "Semi-final" ||
              assessment.module_section.title == "Final";
        return assessment.published && assessment.type != "exam" && checkFilter;
      });
    },
    getFinalGrades(grade1, grade2) {
      const grade = grade1 * 0.6 + grade2 * 0.4;
      return grade;
    },
    getEqui(ave) {
      return equivalence[ave];
    },
    getAverage(type, id) {
      const total = this.getTotal(type, id);
      const ave = Math.ceil(
        (total /
          this.assessments(type).reduce(
            (total, item) => total + Number(item.max_score),
            0
          )) *
          100
      );
      return ave ? ave : 0;
    },
    getTotal(type, id) {
      const score = Object.values(
        this.assessments(type)
          .filter((item) => !!item.response.find((i) => i.user_id == id))
          .map((item) => {
            let titem = item.response.find((i) => i.user_id == id).score;
            return titem ? JSON.parse(titem) : { re: 0 };
          })
      );
      let score1 = score.reduce((total, item) => {
        return (
          total + Object.values(item).reduce((d, i) => Number(d) + Number(i), 0)
        );
      }, 0);

      console.log("ASSESS", score1);
      return score1;
    },
  },
};
</script>

<style>
</style>
