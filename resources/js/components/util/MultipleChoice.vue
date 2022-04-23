<template>
  <div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
      <div class="col-lg-12 justify-content-center">
        <div class="card_box position-relative  mb_30 white_bg ">
          <div class="box_body">
            <h5 class="">{{ number }}. {{ question.question }}</h5>
            <p class="f-w-400 ">{{ question.optional }}</p>
            <div v-for="choice in question.choices" :key="choice.choice" style="padding-top: 10px;" class="form-check">
              <input class="form-check-input" type="radio" :name="choice.choice" id="exampleRadios1" onclick="return false;" :checked="choice.correct">
              <label class="form-check-label" for="exampleRadios1">
                {{ choice.choice }} <i class="fa fa-check" v-if="choice.correct"></i>
              </label>
            </div>

          </div>
        </div>
        <div style="padding: 20px; border-top: 1px solid #f2f4ff;">
          <button @click="removeQuestion" style="background-color: #df0000e6;" class="btn btn-primary2"><i style="font-size: 15px; opacity: 1;" class="far fa-trash-alt"></i></button> |
          <button :data-target="`#msModal${question.id}`" data-toggle="modal" class="btn btn-primary2"><i style="font-size: 15px; opacity: 1;" class="far fa-edit"></i></button>
        </div>
      </div>
    </div>
    <!-- Modal mc-->
    <div data-backdrop="false" class="modal" :id="`msModal${question.id}`" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div style="z-index: 10000;" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="form-row align-items-center">
              <div style="width: 100%;" class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Question</label>
                <textarea v-model="equestion" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>
              <div class="col-auto">
                <label class="sr-only" for="inlineFormInputGroup"></label>
                <div class="input-group mb-2">
                  <input v-model="choiceToAdd.choice" type="text" class="form-control" id="inlineFormInputGroup" placeholder="choices here..">
                </div>
              </div>
              <div class="col-auto">
                <div class="form-check mb-2">
                  <input v-model="choiceToAdd.correct" class="form-check-input" type="checkbox" id="autoSizingCheck">
                  <label class="form-check-label" for="autoSizingCheck">
                    Correct Answer
                  </label>
                </div>
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-primary2 mb-2" @click="addChoice">Add</button>
              </div>
            </div>
            <div>
              <form style="font-size: 17px;" class="form-check">
                <div style="padding-bottom: 5px; color: #00C3FF;" class="form-check" v-for="(choice,i) in question.choices" :key="i">
                  <input class="form-check-input" type="radio" name="exampleRadios" :checked="choice.correct" @click="changeCorrectAnswer(choice.choice)" :id="`choice${i}`" value="d">
                  <label class="form-check-label" style="color:#444" :for="`choice${i}`">
                    {{ choice.choice }} &nbsp;&nbsp;&nbsp;
                  </label>
                  <a style="padding: 2px 5px; font-size: 10px; background-color: red; border-color: red;" class="btn btn-primary" @click="removeChoice(choice.choice)"> <i class="far fa-trash-alt"></i></a>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button @click="saveChanges" type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal MC end-->
  </div>
</template>

<script>
export default {
  props: ["question", "number"],
  data: () => ({
    ecorrectAnswer: "",
    equestion: "",
    choiceToAdd: {},
  }),
  mounted() {
    this.ecorrectAnswer = this.question.correctAnswer;
    this.equestion = this.question.question;
  },
  methods: {
    addChoice() {
      if (this.choiceToAdd && !this.choiceToAdd.choice) return;
      if (
        this.question.choices.find(
          (choice) => choice.choice == this.choiceToAdd.choice
        )
      )
        return;
      const choice = this.choiceToAdd;
      if (choice.correct) {
        this.question.choices = this.question.choices.map((choice) => {
          delete choice.correct;
          return choice;
        });
      }
      this.choiceToAdd = {};
      this.question.choices.push(choice);
    },
    changeCorrectAnswer(name) {
      this.question.choices = this.question.choices.map((choice) => {
        delete choice.correct;
        if (choice.choice == name) {
          choice.correct = true;
        }
        return choice;
      });
    },
    removeChoice(choice) {
      this.question.choices = this.question.choices.filter(
        (choice1) => choice1.choice != choice
      );
    },
    removeQuestion() {
      this.$emit("removeQuestion", this.question);
    },
    saveChanges() {
      this.$emit("updateQuestion", {
        oldQuestion: this.question,
        newQuestion: {
          ...this.question,
          question: this.equestion,
          correctAnswer: this.ecorrectAnswer,
        },
      });
    },
  },
};
</script>

<style>
</style>
