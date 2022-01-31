require("./bootstrap");
import Swal from "sweetalert2";
import DropZone from "dropzone-vue";
import "dropzone-vue/dist/dropzone-vue.common.css";

import joinClass from "./components/modals/joinClass.vue";
import AuthForm from "./components/AuthForm.vue";
import ModuleSection from "./components/ModuleSection.vue";
import CreateAssessment from "./components/CreateAssessment.vue";
import AssessmentView from "./components/AssessmentView.vue";
import CheckResponse from "./components/CheckResponse.vue";
import ExcelGrades from "./components/ExcelGrades.vue";
import { createApp } from "vue";

const app = createApp({});
app.config.globalProperties.$Swal = Swal;
app.component("join-class", joinClass);
app.component("auth-form", AuthForm);
app.component("module-section", ModuleSection);
app.component("create-assessment", CreateAssessment);
app.component("assessment-response", AssessmentView);
app.component("check-response", CheckResponse);
app.component("excel-grades", ExcelGrades);
app.use(DropZone);
app.mount("#app");
