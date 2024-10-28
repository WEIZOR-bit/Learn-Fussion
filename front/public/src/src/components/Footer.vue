<template>
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-logo">
        <img src="@/assets/logo-white.png" alt="LearnFusion Academy" class="footer-logo-image" />
      </div>

      <div class="footer-links">
        <div class="footer-column">
          <a href="#">Teach</a>
          <a href="#">Download the app</a>
          <a href="#">About Us</a>
          <a href="#">Our coordinates</a>
          <a href="#">LFA Business</a>
        </div>
        <div class="footer-column">
          <a href="#">Career</a>
          <a href="#">Blog</a>
          <a href="#">Help and Support</a>
          <a href="#">Partner</a>
          <a href="#">Investors</a>
        </div>
        <div class="footer-column">
          <a href="#">Terms of Use</a>
          <a href="#">Privacy Policy</a>
          <a href="#">Sitemap</a>
          <a href="#">Accessibility Statement</a>
          <a href="#">Cookie settings</a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>© 2024 Udemy, Inc.</p>
    </div>
  </footer>
</template>

<style scoped>
.footer {
  background-color: #7D4BB5;
  padding: 20px 40px;
  color: white;
}

.footer-content {
  display: flex;
  flex-direction: column;
  align-items: start;
}

.footer-logo {
  scale: 150%;
  margin-left: 40px;
}

.footer-logo img {
  max-width: 120px;
  height: auto;
}

.footer-links {
  display: flex;
  justify-content: space-between;
}

.footer-column {
  display: flex;
  flex-direction: column;
  margin: 10px 100px 2px 10px;
}

.footer-column a {
  color: white;
  text-decoration: none;
  margin-bottom: 4px;
  font-size: 14px;
}

.footer-column a:hover {
  text-decoration: underline;
  background: none;
}

.footer-bottom {
  text-align: right;
  margin-top: 20px;
  font-size: 12px;
  color: white;
}

.footer-bottom p {
  margin: 0;
}
</style>
