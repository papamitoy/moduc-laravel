<template>
  <div v-if="!loading" class="row col-12" style="width:100%">
    <div class="col-md-8 col-lg-8 col-xl-6 box-col-8">
      <div class="col-lg-12">
        <h4 style="opacity: .7;" class="color_pink">Preview</h4>
        <div class="card_box box_shadow position-relative mb_30">
          <div class="white_box_tittle ">
            <div class="main-title2 ">

              <div class="form-group mb-0 mt-2">
                <label for="inputState">Questionnaire Type</label>
                <select v-model="assessmentType" id="inputState" class="form-control ">
                  <option value="exam">Major Exam</option>
                  <option value="assessment">Assessment</option>
                  <option value="activity">Activity</option>
                </select>

                <select v-model="examType" v-if="assessmentType == 'exam'" id="inputState" class="form-control mt-2">
                  <option value="prelim">Prelim</option>
                  <option value="midterm">Midterm</option>
                  <option value="semifi">Semi-Final</option>
                  <option value="final">Final</option>

                </select>
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
                <Essay enableEdit="true" @removeQuestion="removeQuestion" :number="index+1" @updateQuestion="updateQuestion" v-if="question.type == 'essay'" :question="question" />
                <MultipleChoice enableEdit="true" @removeQuestion="removeQuestion" :number="index+1" @updateQuestion="updateQuestion" v-else-if="question.type == 'multiple-choice'" :question="question" />
                <ShortAnswer enableEdit="true" @removeQuestion="removeQuestion" :number="index+1" @updateQuestion="updateQuestion" v-else-if="question.type=='short-answer'" :question="question" />
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

          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-4 col-xl-6 box-col-4 ">
      <h4 style="opacity: .7;" class="color_pink">Edit Assesment here</h4>
      <div style="background-color: #FBF6F0;" class="white_card mb_30 card_box box_shadow">
        <div class="white_card_header">

        </div>
        <div class="white_card_body">
          <div class="card-body">
            <div class="form-group">
              <label for="inputAddress">Form Title</label>
              <input v-model="title" type="text" class="form-control" id="inputAddress" placeholder="Untitled Form" style="font-size: 25px;">

            </div>
            <div class="form-group">
              <label for="inputAddress">Form Description</label>
              <input v-model="description" type="text" class="form-control" id="inputAddress" placeholder="Description" style="font-size: 15px;">
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputState">Questioner Type</label>
                <select v-model="questionType" id="inputState" class="form-control">
                  <option value="e">Essay</option>
                  <option value="mc">Multiple Choice</option>
                  <option value="sa">Short Answer</option>
                </select>
                <small id="emailHelp" class="form-text text-muted">Choose what type of question.</small>
              </div>
              <div class="form-group col-md-4">
                <input v-model="shuffle" type="checkbox" id="shuffle" />
                <label for="shuffle">Shuffle</label>
                <small id="emailHelp" class="form-text text-muted">Whether the question is shuffled.</small>
              </div>

            </div>

            <div v-if="questionType == 'sa'" style="border-top: 1px solid rgb(211, 211, 211); padding: 15px 0px 15px 0px;">

              <div class="form-group">
                <h5>Short Answer</h5>
                <label for="inputAddress">Question</label>
                <textarea v-model="questionSA.question" class="form-control" id="" placeholder="Your Question here.."></textarea>
              </div>
              <div class="form-group">
                <small for="inputAddress">Oprional Question</small>
                <textarea v-model="questionSA.optional" style="font-size: 15px;" class="form-control" id="" placeholder="Your Question here.."></textarea>
              </div>
              <div class="form-group">
                <label for="">Points</label>
                <input class="form-control" type="number" v-model="questionE.points" placeholder="Points">
              </div>
              <!-- to design start-->
              <!-- <div>
              <input v-model="questionSA.fileUploadEnable" type="checkbox" name="iffileuploadsa">
              <label for="isfileuploadsa">Enable file upload</label>
            </div> -->
              <!-- to design end -->
              <div class="form-group">
                <label for="inputAddress">Answer</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input type="checkbox" aria-label="Checkbox for following text input">
                    </div>
                  </div>
                  <input v-model="questionSA.correctAnswer" type="text" class="form-control" aria-label="Text input with checkbox">
                </div>
              </div>
              <button type="submit" class="btn btn-primary" @click="submitShortAnswer()">Submit</button>
            </div>
            <!-- ESSAY QUESTION -->
            <div v-else-if="questionType == 'e'" style="border-top: 1px solid rgb(211, 211, 211); padding: 15px 0px 15px 0px;">

              <div class="form-group">
                <h5>Long Answer / Essay</h5>
                <label for="inputAddress">Question</label>
                <textarea v-model="questionE.question" class="form-control" id="" placeholder="Your Question here.."></textarea>
              </div>

              <div class="form-group">
                <small for="inputAddress">Oprional Question</small>
                <textarea v-model="questionE.optional" style="font-size: 15px;" class="form-control" id="" placeholder="Your Question here.."></textarea>
              </div>
              <div class="form-group">
                <label for="">Points</label>
                <input class="form-control" type="number" v-model="questionE.points" placeholder="Points">
              </div>
              <!-- to design start-->
              <!-- <div>
              <input v-model="questionE.fileUploadEnable" type="checkbox" name="iffileuploadsa">
              <label for="isfileuploadsa">Enable file upload</label>
            </div> -->
              <!-- to design end -->
              <button type="submit" class="btn btn-primary" @click="submitEssay()">Submit</button>
            </div>

            <!-- div create question-->
            <div v-else-if="questionType == 'mc'" style="border-top: 1px solid rgb(211, 211, 211); padding: 15px 0px 15px 0px;">

              <div class="form-group">
                <h5>Multiple Choice</h5>
                <label for="inputAddress">Question</label>
                <textarea v-model="questionMC.question" class="form-control" id="" placeholder="Your Question here.."></textarea>
              </div>
              <div class="form-group">
                <small for="inputAddress">Optional Question</small>
                <textarea v-model="questionMC.optional" style="font-size: 15px;" class="form-control" id="" placeholder="Your Question here.."></textarea>
              </div>
              <div class="form-group">
                <label for="">Points</label>
                <input class="form-control" type="number" v-model="questionMC.points" placeholder="Points">
              </div>
              <!-- to design start-->
              <!-- <div>
              <input v-model="questionMC.fileUploadEnable" type="checkbox" name="iffileuploadsa">
              <label for="isfileuploadsa">Enable file upload</label>
            </div> -->
              <!-- to design end -->
              <div class="form-group">
                <label for="inputAddress">Answer</label>
                <div class="form-row align-items-center">

                  <div class="col-auto">
                    <div class="input-group mb-2">
                      <input v-model="setChoice.choice" type="text" class="form-control" id="inlineFormInputGroup" placeholder="">
                    </div>
                  </div>
                  <div class="col-auto">
                    <div class="form-check mb-2">
                      <input v-model="setChoice.correct" class="form-check-input" type="checkbox" id="autoSizingCheck">
                      <label class="form-check-label" for="autoSizingCheck">
                        Correct Answer
                      </label>
                    </div>
                  </div>
                  <div class="col-auto">
                    <button type="submit" class="btn btn-primary2 mb-2" @click="addChoice()">Add</button>
                  </div>
                </div>
                <div>

                  <div v-for="choice in questionMC.choices" :key="choice.choice" style="padding-bottom: 5px;" class="form-check">
                    <input :checked="choice.correct" onclick="return false;" class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="d">
                    <label class="form-check-label" for="exampleRadios4">
                      {{ choice.choice }} &nbsp;&nbsp;&nbsp;
                    </label>
                    <a @click="removeChoice(choice.choice)" style="padding: 2px 5px; font-size: 10px; background-color: red; border-color: red;" class="btn btn-primary"><i class="far fa-trash-alt"></i></a>
                  </div>

                </div>
              </div>
              <button type="submit" class="btn btn-primary" @click="submitMultipleChoice()">Submit</button>

            </div>

          </div>
          <button type="submit" class="btn btn-primary" @click="save()">
            <div class="spinner-border text-sm" role="status" v-if="saving">
              <span class="sr-only">Loading...</span>
            </div>
            <span v-else>Save</span>
          </button>
        </div>
      </div>

    </div>
  </div>
  <div v-else>
    <div class="col-12">Loading</div>
  </div>
</template>

<script>
import Essay from "./util/Essay.vue";
import MultipleChoice from "./util/MultipleChoice.vue";
import ShortAnswer from "./util/ShortAnswer.vue";
export default {
  components: {
    Essay,
    MultipleChoice,
    ShortAnswer,
  },
  mounted() {
    var url = new URL(location.href);
    var id = url.searchParams.get("id");
    let that = this;
    if (id) {
      this.loading = true;
      console.log("has ID");
      axios
        .post("/api/assessment", {
          id,
        })
        .then((res) => {
          console.log(res);
          if (res.data.success) {
            that.selectedId = res.data.data.id;
            that.questions = JSON.parse(res.data.data.questions);
            that.description = res.data.data.description;
            that.shuffle = res.data.data.shuffle == 1;
            that.title = res.data.data.title;
            that.published = res.data.data.published;
            that.assessmentType = res.data.data.type;
            that.examType = res.data.data.exam_type;
          }
          this.loading = false;
        });
    }
  },
  data() {
    return {
      loading: false,
      selectedId: null,
      title: "Untitled Form",
      description: "",
      questionType: "e",
      questions: [],
      questionE: { points: 2 },
      questionMC: { points: 2 },
      questionSA: { points: 2 },
      setChoice: {},
      choices: [],
      assessmentType: "exam",
      shuffle: false,
      published: false,
      examType: "prelim",
      saving: false,
    };
  },
  methods: {
    updateQuestion(pquestion) {
      const { oldQuestion, newQuestion } = pquestion;
      this.questions = this.questions.map((question) => {
        if (oldQuestion.id == question.id) {
          question = newQuestion;
        }
        return question;
      });
      this.saveAssessment(false);
    },
    removeQuestion(pquestion) {
      this.questions = this.questions.filter((question) => {
        return question.id != pquestion.id;
      });
      this.saveAssessment(false);
    },
    submitEssay() {
      this.questionE = {
        id: new Date().getTime(),
        ...this.questionE,
        type: "essay",
      };
      this.questions.push(this.questionE);
      this.questionE = { points: 2 };
      console.log(this.questions);
      this.saveAssessment(false);
    },
    submitMultipleChoice() {
      this.questionMC = {
        id: new Date().getTime(),
        ...this.questionMC,
        type: "multiple-choice",
      };
      this.questions.push(this.questionMC);
      this.questionMC = { points: 2 };
      this.choices = [];
      this.setChoice = {};
      console.log(this.questions);
      this.saveAssessment(false);
    },
    submitShortAnswer() {
      this.questionSA = {
        id: new Date().getTime(),
        ...this.questionSA,
        type: "short-answer",
      };
      this.questions.push(this.questionSA);
      this.questionSA = { points: 2 };
      console.log(this.questions);
      this.saveAssessment(false);
    },
    addChoice() {
      if (this.choices.find((choice) => choice.choice == this.setChoice.choice))
        return;
      this.choices.push(this.setChoice);
      this.questionMC.choices = this.choices;
      this.setChoice = {};
    },
    removeChoice(selected) {
      this.choices = this.choices.filter((choice) => choice.choice != selected);
      this.questionMC.choices = this.choices;
    },

    save() {
      this.saveAssessment(true);
    },
    saveAssessment(isReroute = true) {
      if (this.saving) {
        return;
      }

      this.saving = true;
      let that = this;
      var url = new URL(location.href);
      var subid = url.searchParams.get("subject_id");
      var secid = url.searchParams.get("section_id");
      const payload = {
        questions: this.questions,
        title: this.title,
        description: this.description,
        assessmentType: this.assessmentType,
        shuffle: this.shuffle,
        selectedId: this.selectedId,
        examType: this.examType,
      };
      if (subid != null) payload["subject_id"] = subid;
      if (secid != null) payload["section_id"] = secid;

      axios
        .post("/api/assessment/create", payload)
        .then((res) => {
          console.log(res);
          if (res.data.success) {
            var url = new URL(location.href);
            var redirect = url.searchParams.get("redirect");
            console.log(redirect);
            if (isReroute) {
              this.$Swal.fire("Success", "Saved successfully", "success");
            }
            if (redirect && isReroute) {
              return (location.href = "/subject/" + redirect);
            }
            that.selectedId = res.data.data.id;

            var url = new URL(location.href);
            url.searchParams.set("id", res.data.data.id);
            //   location.href = url;
            window.history.pushState({ path: url }, "", url);
          }
          this.saving = false;
        })
        .catch((err) => {
          console.log(err);
          this.$Swal
            .fire("Warning", "An error occur please try again later", "warning")
            .then(() => {
              location.reload();
            });
          this.saving = false;
          return;
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
