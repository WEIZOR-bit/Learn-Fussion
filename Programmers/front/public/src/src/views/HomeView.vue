<script setup>
import TopBar from "@/components/TopBar.vue";
import Sidebar from "@/components/Sidebar.vue";
import LoadingCircle from "@/components/LoadingCircle.vue";
import {faCircleRight} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {library} from "@fortawesome/fontawesome-svg-core";
import Footer from "@/components/Footer.vue";
library.add(faCircleRight);
</script>

<script>
import courseImage from '@/assets/course-image.jpg';
import axios from "axios";
export default {
  data() {
    return {
      recommendedCourses: [],
      popularCourses: [],
      loadingCourses: true
    };
  },
  async mounted() {
    document.title = 'Home';
    await this.fetchCourses();
  },
  methods: {
    async fetchCourses() {
      try {
        const response = await axios.get('http://localhost/api/public/profile/courses');
        const response_courses = response.data;

        response_courses.data.forEach(course => {

          this.loadingCourses = false;

          this.recommendedCourses.push({
            id: course.id,
            author: course.author,
            category: course.category,
            title: course.name,
            image: courseImage,
          });

          this.popularCourses.push({
            id: course.id,
            author: course.author,
            category: course.category,
            title: course.name,
            image: courseImage,
          });
        });

      } catch (error) {
        console.error('Error fetching courses:', error);
      }
    }
  }
};
</script>

<template>
  <div id="container">
    <div class="page-wrapper">
      <Sidebar/>
      <div class="page-content">
        <TopBar/>
        <div class="bottom-content">

          <div class="banner">
            <div class="banner-content">
              <h4>ONLINE COURSE</h4>
              <h1>Sharpen Your Skills with Professional Online Courses</h1>
              <button class="join-btn">
                Join Now
                <font-awesome-icon
                    icon="circle-right"
                    class="join-icon"
                />
              </button>
            </div>
          </div>

          <div class="categories">
            <h3>Categories</h3>
            <div class="categories-buttons">
              <div class="category-btn">Development</div>
              <div class="category-btn">UI/UX Design</div>
              <div class="category-btn">Branding</div>
            </div>
          </div>

          <section class="course-section">
            <div class="section-header">
              <h2>Recommended</h2>
              <a href="/courses">See all</a>
            </div>

            <LoadingCircle v-if="loadingCourses"/>

            <div class="courses-grid">
              <div class="course-card" v-for="course in recommendedCourses" :key="course.id + '-recommended'">
                <div class="course-info">
                  <div class="author-info">
                    <img src="@/assets/user.png" class="author-avatar" alt="Author" />
                    <span class="author-name">{{ course.author }}</span>
                  </div>
                  <div class="course-category">{{ course.category }}</div>
                </div>
                <div class="course-image-wrapper">
                  <img :src="course.image" alt="Course Image" class="course-image" />
                </div>
                <h3 class="course-title">{{ course.title }}</h3>
              </div>
            </div>
          </section>

          <section class="course-section">
            <div class="section-header">
              <h2>Popular Now</h2>
              <a href="/courses">See all</a>
            </div>

            <LoadingCircle v-if="loadingCourses"/>

            <div class="courses-grid">
              <div class="course-card" v-for="course in popularCourses" :key="course.id + '-popular'">
                <div class="course-info">
                  <div class="author-info">
                    <img src="@/assets/user.png" class="author-avatar" alt="Author" />
                    <span class="author-name">{{ course.author }}</span>
                  </div>
                  <div class="course-category">{{ course.category }}</div>
                </div>
                <div class="course-image-wrapper">
                  <img :src="course.image" alt="Course Image" class="course-image" />
                </div>
                <h3 class="course-title">{{ course.title }}</h3>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
    <Footer/>
  </div>
</template>

<style scoped>
  #container {
    width: 100%;
    height: 100vh;
  }

  .page-wrapper {
    display: flex;
    overflow: hidden;
  }

  .page-content {
    display: flex;
    flex-direction: column;
    width: calc(100% - 200px);
    height: 100%;
  }

  .bottom-content {
    height: 95%;
    width: 100%;
    overflow-y: auto;
    padding: 20px;
    color: #333;
    display: flex;
    flex-direction: column;
  }

  .join-icon {
    margin-left: 5px;
    scale: 115%;
  }

  .banner {
    background-image: url('@/assets/courses-background.jpg');
    background-size: cover;
    background-position: center;
    border-radius: 20px;
    padding: 40px;
    position: relative;
  }

  .banner-content {
    position: relative;
    z-index: 2;
  }

  .banner-content h1 {
    font-weight: bold;
    font-size: 32px;
    font-family: 'Quattrocento', sans-serif;
    width: 30%;
  }

  .join-btn {
    background-color: #8559BA;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 100px;
    cursor: pointer;
    margin-top: 20px;
    font-size:16px;
  }

  .categories {
    margin: 30px 0;
  }

  .categories > h3 {
    font-size: 20px;
    font-weight: 500;
  }

  .categories-buttons {
    display: flex;
    justify-content: space-between;
  }

  .category-btn {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 30px;
    padding: 10px 20px;
    cursor: pointer;
    font-weight: bold;
    flex:1;
    text-align: center;
    margin: 3px 10px;
  }

  .section-header {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
  }

  .section-header h2 {
    font-size: 1.5em;
    margin: 0;
  }

  .section-header a {
    color: #8559BA;
    margin-right: 10px;
  }

  .section-header a:hover {
    color: #8559BA;
    background: none;
    text-decoration: underline;
  }

  .author-info {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .author-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
  }

  .author-name {
    font-weight: bold;
    font-size: 1em;
  }

  .course-category {
    display: inline-block;
    padding: 5px 10px;
    background-color: #f0f0f0;
    border-radius: 15px;
    font-size: 0.8em;
    font-weight: bold;
    height: fit-content;
  }

  .courses-grid {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
  }

  .course-card {
    flex: 1 1 calc(33.333% - 20px);
    width: 320px;
    background-color: white;
    border-radius: 20px;
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
    padding: 10px;
  }

  .course-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
  }

  .course-image-wrapper {
    position: relative;
  }

  .course-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 20px;
  }

  .course-title {
    font-size: 20px;
    margin: 5px 0;
    padding: 0 10px;
    font-weight: normal;
    text-align: left;
  }
</style>