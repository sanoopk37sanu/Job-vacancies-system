<template>
  <div>
    <div v-if="isVisible">

      <button @click="createNewJob" class="btn btn-success mb-3 float-end"  style="text-align: right;">
        Add Job
      </button>
    <div class="container mt-5">
     <h2>Job Vacancy List</h2>
    <table class="table table-striped">
      <thead>
        <tr>
         <th>Job</th>
          <th>Description</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(job, index) in jobVacancy" :key="job.id">
          <td>{{ job.job_name }}</td>
          <td>{{ job.description }}</td>
           <td>
            <span :class="{'badge': true, 'bg-success': job.status === '1', 'bg-secondary': job.status !== '0'}">
              {{ job.status === '1' ? 'Active' : 'Inactive' }}
            </span>
          </td>
          <td>
            <button class="btn btn-primary btn-sm" @click="editJob(job)">Edit</button>
            <button class="btn btn-danger btn-sm" @click="deleteJob(job.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
    </div>
    <div v-if="isAddingJob">
      <JobForm v-if="selectedJob" :jobData="selectedJob" @submit="saveJob"  @back="back"/>
    </div>
  </div>
</template>

<script>
import JobForm from "./JobForm.vue";
import axios from "axios";

export default {
  components: {
    JobForm,
  },
  data() {
    return {
      jobVacancy: [],
      selectedJob: null,
      isVisible: true,
      isAddingJob: false,
      successMessage: "",
    };
  },
  created() {
     this.fetchVacancyList();
  },
  methods: {
    async fetchVacancyList() {
      try {
      axios.get('/api/vacancy-list/')
        .then(response => {

        this.jobVacancy=response.data.data;

          this.loading = false;
        })
        .catch(error => {
          this.error = error.message;
          this.loading = false;
        });
      } catch (error) {
        console.error("Error fetching jobs:", error);
      }
    },
    createNewJob() {
      this.isAddingJob = !this.isAddingJob;
      this.isVisible = !this.isVisible;

      this.selectedJob = {
        description: "",
        status: "",
        start_date: "",
        end_date: "",
        job_id: "",
        id: "",
      };
    },
   back(){
   this.isAddingJob = !this.isAddingJob;
      this.isVisible = !this.isVisible;
   },
    editJob(job) {
      this.selectedJob =job
       this.isAddingJob = !this.isAddingJob;
      this.isVisible = !this.isVisible;
    },
    async saveJob(description,start_date,end_date,job_id,status,id) {

          let jobData = {
            description: description,
             end_date: end_date,
            start_date: start_date,
             job_id: job_id,
             status:status
          };
      try {
        if (id>0) {
          axios.post(`/api/vacancy-update/${id}`, jobData)
            .then((response) => {
              if(response.data.status=="success")
                {
             alert('Job Vacancy Updated successfully')
              this.errorMessage = "";
                }else{
             this.errorMessage = "Operation Failed";
                }

            })
            .catch((error) => {
              this.errorMessage =
                "Error update job: " +
                (error.response?.data?.message || error.message);
              this.successMessage = "";
            });

             this.isAddingJob = !this.isAddingJob;
      this.isVisible = !this.isVisible;
        } else {

 if(status)
 {
          axios.post("/api/add-vacancy", jobData)
            .then((response) => {
                if(response.data.status=="success")
                {
            //   this.successMessage = "Job saved successfully!";
              alert('Job Vacancy saved successfully')
              this.errorMessage = "";
                }else{

             this.errorMessage = "Operation Failed";
                }
              //this.clearForm();
            })
            .catch((error) => {
              this.errorMessage =
                "Error saving job: " +
                (error.response?.data?.message || error.message);
              this.successMessage = "";
            });
  this.isAddingJob = !this.isAddingJob;
      this.isVisible = !this.isVisible;
        }
      }

        //this.selectedJob = null;
      } catch (error) {
        console.error("Error saving job:", error);
      }
    },
    async deleteJob(id) {

      if (confirm("Are you sure you want to delete this job?")) {
        try {
          await axios.delete(`/api/vacancy-delete/${id}`);
          this.fetchVacancyList();
        } catch (error) {
          console.error("Error deleting job:", error);
        }
      }
    },
  },
};
</script>

<style scoped>
/* Add any scoped styles here */
</style>
