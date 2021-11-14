<template>

  <div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
      <div class="col-lg-12 justify-content-center">
        <div class="card_box position-relative  mb_30 white_bg ">
          <div class="box_body ">
            <h5 class="">{{ question.title }}</h5>
            <p class="f-w-400 ">{{ question.optional }}</p>
            <input type="text" style="border: 0; outline: 0; border-bottom: 1px solid #03a8f45e; font-size: 1rem;  color: #000; width: 50%; padding-top: 15px;" placeholder="Your Answer">

          </div>
          <div style="padding: 20px; border-top: 1px solid #f2f4ff;">
            <a href="" style="background-color: #df0000e6;" class="btn btn-primary2"><i style="font-size: 15px; opacity: 1;" class="far fa-trash-alt"></i></a> |
            <a href="" class="btn btn-primary2 mr-1"><i style="font-size: 15px; opacity: 1;" class="far fa-clone"></i></a>
            <a href="" class="btn btn-primary2"><i style="font-size: 15px; opacity: 1;" class="far fa-edit"></i></a>
          </div>
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
