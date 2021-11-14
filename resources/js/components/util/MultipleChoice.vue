<template>
  <div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
      <div class="col-lg-12 justify-content-center">
        <div class="card_box position-relative  mb_30 white_bg ">
          <div class="box_body">
            <h5 class="">{{ question.title }}</h5>
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
          <a href="" style="background-color: #df0000e6;" class="btn btn-primary2"><i style="font-size: 15px; opacity: 1;" class="far fa-trash-alt"></i></a> |
          <a href="" class="btn btn-primary2 mr-1"><i style="font-size: 15px; opacity: 1;" class="far fa-clone"></i></a>
          <a href="" class="btn btn-primary2"><i style="font-size: 15px; opacity: 1;" class="far fa-edit"></i></a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["question"],
};
</script>

<style>
</style>
