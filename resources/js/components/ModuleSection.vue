<template>
  <div class="col-lg-5" v-if="studentEnable || is_adviser">

    <div @mouseenter="showUpload" @dragover="showUpload" @dragend="hideUpload" @mouseleave="hideUpload" class="disabled card_box box_shadow position-relative mb_30">

      <div @mouseenter="showBtn = true" v-if="active == 0" class="overlay-section disabled">
      </div>

      <div @mouseleave="showBtn = false" v-show="showBtn" v-if="active == 0 && is_adviser" class="overlay-section1">
        <div class="section-hover">
          <div class="box-container">
            <button class="btn btn-primary" @click="enableSection">Enable</button>
          </div>
        </div>
      </div>

      <div class="white_box_tittle mb-4">

        <div class="main-title2 position-relative" style="width:100%">

          <div v-if="is_adviser" class="position-absolute" style="right:0;">
            <a :href="`/subject/${subject.id}/section/${section.id}/assessment/create`" class="btn-sm btn-primary rounded-pill px-3 py-1 text-sm">Add Assessment</a>
          </div>
          <!-- <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">Disable Section</a>
    <a class="dropdown-item" href="#">Delete</a>
  </div>
</div> -->

          <h4 class="mb-2 nowrap">{{ section.title }}</h4>
          <!-- <p>Preliminary stage</p> -->
          <p v-if="is_adviser"><span style="color: red">*NOTE:</span> you need to upload Module soft-copy for students</p><br>

          <div class="form-group mb-0 typography form-inline" v-if="is_adviser">
            <p><mark>Upload your module here...</mark></p><br /><br />
            <div class="form-row" style="width:100%">
              <DropZone :clickable="uploadClickable" v-if="uploadClickable" @uploaded="uploadedModule" :headers="headers" style="width:100%" :acceptedFiles="['pdf','docx','pptx','ppt','xlsx','png','jpg']" paramName="fileZone" :maxFiles="Number(10000000000)" :url="`/upload/module-section/${subject.id}/${section.id}`" :uploadOnDrop="true" :multipleUpload="true" :parallelUpload="1" />
              <div v-else style="height:64px">

              </div>
            </div>
          </div>
          <div class="mt-4">
            <h4>Modules:</h4>
            <div v-for="file in subject.module_files" :key="file.id">
              <a :href="'../storage/'+file.module_file.split('/').slice(1).join('/')" v-if="file.module_section_id == section.id"> {{ file.file_name }}</a>
            </div>
          </div>
        </div>
      </div>
      <div class="box_body">
        <div class="default-according" id="accordion">

          <div class="card " v-for="(assessment,i) in assessmentList" :key="i">
            <div v-if="isShow(assessment.published)">

              <div class="card-header parpel_bg" id="headingOne" style="overflow: auto;">
                <h5 class="mb-0">

                  <button class="btn btn-link collapsed" data-toggle="collapse" :data-target="`#collapseOne${section.id+''+assessment.id}`" aria-expanded="false" aria-controls="collapseOne">{{ assessment.title }}</button>
                  <span style="font-size: 12px; font-weight: normal; ">{{ assessment.deadline ? "Due "+getDate(assessment.deadline,"LL") : "" }}</span>
                  <button v-if="is_adviser" style="padding-left: 10px; margin-top:5px; font-size:12px" class="float-right btn btn-sm  btn-primary rounded-pill" @click="gotoEdit(assessment.id)">Update</button>

                  <p style="margin-top: 12px;" class="badge badge-warning float-right" v-if="is_adviser && !assessment.published">Unpublished</p>
                  <p style="margin-top: 12px;" class="badge badge-warning float-right" v-else-if="is_adviser && assessment.published">Published</p>

                </h5>
              </div>
              <div class="collapse" :id="`collapseOne${section.id+''+assessment.id}`" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                  <div style="display:flex; justify-content:space-between;">
                    <p style="font-size: 10px;">Posted {{ getDate(assessment.created_at,"ll") }}</p><br>
                    <div style="padding: 10px; display:flex;" v-if="is_adviser">
                      <div class="border-left">
                        <h3>{{ getResponseCount(assessment.response,"pending") }}</h3><small>Pending Responses</small>
                      </div>
                      <div class="border-left">
                        <h3>{{ getResponseCount(assessment.response) }}</h3><small>Responded</small>
                      </div>
                    </div>
                    <div v-else>
                      <div v-if="getScore(assessment.response)"><span>SCORE: </span> <span style="font-size:20px"> {{ getScore(assessment.response) }}</span></div>
                    </div>
                  </div>
                  <p>{{ assessment.description }}</p><br><br>
                  <div v-for="file in assessment.files" :key="file.id">
                    <a :href="file.file"><i class="fa fa-file" aria-hidden="true"> &nbsp; &nbsp;</i>{{ file.name }}</a><br><br>
                  </div>

                  <div class="border_bottom_1px"></div><br>
                  <div v-if="is_adviser" style="display:flex; justify-content:space-between;">
                    <a :href="`/subject/${subject.id}/assessment/check-response?assessment_id=${assessment.id}`">Check Respond</a>
                    <button v-if="is_adviser" style="padding-left: 10px; margin-top:5px; font-size:12px" class="btn btn-sm  btn-danger rounded-pill" @click="removeAssessment(assessment.id,subject.id)">Remove</button>

                  </div>
                  <a :href="`/subject/${subject.id}/response?assessment_id=${assessment.id}`" v-else target="_BLANK">Respond</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import moment from "moment";
export default {
  props: [
    "section1",
    "is_adviser",
    "subject1",
    "assessments",
    "grades",
    "user_id",
  ],
  data() {
    return {
      section: {},
      showBtn: false,
      active: false,
      uploadClickable: false,
      subject: {},
      assessmentList: [],
      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
    };
  },

  mounted() {
    this.active = this.section1.status;
    this.section = this.section1;
    this.subject = this.subject1;
    this.assessmentList = this.assessments;
    console.log(this.studentEnable);
  },
  computed: {
    studentEnable() {
      if (this.section.title == "Prelim") return true;
      if (this.section.title == "Midterm") return true;
      return this.grades.find(
        (grade) =>
          grade.remarks == "pass" &&
          grade.user_id == this.user_id &&
          grade.module_section == "Midterm" &&
          (this.section.title == "Semi-final" || this.section.title == "Final")
      );
    },
  },
  methods: {
    getScore(response) {
      const hasResponse =
        response &&
        response.find((resp) => {
          return resp.user_id == this.user_id;
        });
      if (!hasResponse) return null;
      return (
        hasResponse &&
        hasResponse.score &&
        Object.values(JSON.parse(hasResponse.score)).reduce(
          (total, num) => total + Number(num),
          0
        )
      );
    },
    removeAssessment(id, subject_id) {
      this.$Swal
        .fire({
          title: "Do you want to remove this assessment?",
          showDenyButton: true,
          confirmButtonText: "Yes",
          denyButtonText: `No`,
          confirmButtonColor: "#00D5DB",
        })
        .then(async (result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            try {
              const data = await axios.post("/api/class/remove/assessment", {
                id: id,
                subject_id: subject_id,
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
    getResponseCount(responses, status = "responded") {
      if (!responses && responses.length == 0) return [];
      if (status == "pending") {
        return responses.filter(
          (response) => response.checked_by == null && response.status == 0
        ).length;
      } else {
        console.log("response", responses);
        return responses.filter((response) => response.checked_by != null)
          .length;
      }
    },
    showUpload() {
      this.uploadClickable = true;
    },
    hideUpload() {
      console.log("HOVER out");
      this.uploadClickable = false;
    },
    uploadedModule(res) {
      if (!!res[0]) {
        axios.post(`/subject/${this.subject.id}/files`).then((res) => {
          if (res.data.success) this.subject = res.data.data;
        });
      }

      console.log("modu", res[0], res);
    },
    gotoEdit(id) {
      location.href = `/subject/${this.subject.id}/section/${this.section.id}/assessment/update?u=${id}`;
    },
    isShow(published) {
      return this.is_adviser ? true : published;
    },
    getDate(date, format) {
      return moment(date).format(format);
    },

    async enableSection() {
      try {
        let data = await axios.post("/api/update-section", {
          section_id: this.section.id,
          status: true,
        });
        if (data.data.success) {
          this.active = true;
        }
      } catch (e) {
        console.log(e);
      }
    },
  },
};
</script>

<style scoped>
.overlay-section1 {
  height: 100%;
  width: 100%;
  z-index: 3101;
  position: absolute;
  top: 0;
  left: 0;
  background: rgba(0, 0, 0, 0.8);
}
.section-hover {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  width: 100%;
}
.box-container {
  background: white;
  padding: 10px 20px;
  border-radius: 10px;
}
.overlay-section {
  height: 100%;
  width: 100%;
  z-index: 2000;
  position: absolute;
  top: 0;
  left: 0;
}
.overlay-section.disabled {
  opacity: 0.5;
  background: #ccc;
}
</style>
