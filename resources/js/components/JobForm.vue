<template>
  <div >
    <h2>{{ job.id ? 'Edit Job' : 'Add Job' }}</h2>
     <button @click="back" class="btn btn-success mb-3 float-end"  style="text-align: right;">
        Back
      </button>
    <form @submit.prevent="handleSubmit">
         <div class="mb-3">
        <label for="status" class="form-label">Job</label>
         <select v-model="job.job_id" class="form-control">
      <option v-for="item in options" :key="item.id" :value="item.id">
        {{ item.job_name }}
      </option>
    </select>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input
          type="text"
          id="description"
          v-model="job.description"
          class="form-control"
          :class="{ 'is-invalid': errors.description }"
          required
        />
        <div class="invalid-feedback">{{ errors.description }}</div>
      </div>
      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select id="status" v-model="job.status" class="form-control" required>
          <option value="1">Active</option>
          <option value="0">InActivate</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="start_date" class="form-label">Start Date</label>
        <input
          type="date"
          id="start_date"
          v-model="job.start_date"
          class="form-control"
          :class="{ 'is-invalid': errors.start_date }"
          required
        />
        <div class="invalid-feedback">{{ errors.start_date }}</div>
      </div>
      <div class="mb-3">
        <label for="end_date" class="form-label">End Date</label>
        <input
          type="date"
          id="end_date"
          v-model="job.end_date"
          class="form-control"
          :class="{ 'is-invalid': errors.end_date }"
          required
        />
        <div class="invalid-feedback">{{ errors.end_date }}</div>
      </div>
      <button type="submit" class="btn btn-primary">
        {{ job.id ? 'Update Job' : 'Add Job' }}
      </button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    jobData: {
      type: Object,
      default: () => ({
        id: null,
        description: '',
        status: '',
        start_date: '',
        end_date: '',
        job_id:''
      }),
    },
  },
  data() {
    return {
      job: this.jobData ,
      options:[],

      errors: {},
    };
  },
  methods: {
    validateForm() {
      this.errors = {};
      if (!this.job.description) this.errors.description = 'Description is required.';
      if (!this.job.start_date) this.errors.start_date = 'Start date is required.';
      if (!this.job.end_date) this.errors.end_date = 'End date is required.';
      return Object.keys(this.errors).length === 0;
    },

      back() {


        this.$emit('back');

    },
    handleSubmit() {
      if (this.validateForm()) {
    //    let jobDataInfo = {
    //         description: this.job.description,
    //         end_date: this.job.end_date,
    //         start_date: this.job.start_date,
    //         job_id: this.job.job_id,
    //         status:this.job.status
    //       };

        this.$emit('submit', this.job.description,this.job.start_date,this.job.end_date,this.job.job_id,this.job.status,this.job.id );
      }
    },  async fetchJobsList() {
      try {

         axios.get('/api/jobs/') // Replace with your API endpoint
        .then(response => {

        this.options=response.data.data;
          this.loading = false;
        })
        .catch(error => {
          this.error = error.message;
          this.loading = false;
        });
      } catch (error) {
        console.error('Error fetching jobs:', error);
      }
    },
  }, created() {
    this.fetchJobsList();
  },
};
</script>

<style scoped>
.is-invalid {
  border-color: #dc3545;
}

.invalid-feedback {
  color: #dc3545;
}
</style>
