const postContainer = document.getElementById("postContainer");
const pagination = document.getElementById("pagination");
const perPageSelect = document.getElementById("perPageSelect");
const sortSelect = document.getElementById("sortSelect");
const showingInfo = document.getElementById("showingInfo");

let perPage = parseInt(localStorage.getItem("perPage")) || +perPageSelect.value;
let currentPage = parseInt(localStorage.getItem("currentPage")) || 1;
let sortOption = localStorage.getItem("sortBy") || sortSelect.value;
let apiSort = sortOption === "newest" ? "-published_at" : "published_at";
sortSelect.value = sortOption;

perPageSelect.value = perPage;
sortSelect.value = sortOption;

async function fetchPosts() {
  console.log("currentPage:", currentPage);
  console.log("perPage:", perPage);
  console.log("apiSort:", apiSort);

  const url = `proxy.php?page=${currentPage}&size=${perPage}&sort=${apiSort}`;

  const res = await fetch(url);
  const response = await res.json();

  console.log("API response:", response);
  return response;
}

async function renderPosts() {
  const response = await fetchPosts();
  const posts = response.data;
  const total = response.meta.total;

  const start = (currentPage - 1) * perPage + 1;
  const end = start + posts.length - 1;

  showingInfo.textContent = `Showing ${start}–${end} of ${total}`;

  postContainer.innerHTML = posts
    .map((post) => {
      const imageUrl = post.medium_image?.[0]?.url || "";
      return `
        <div class="card">
          <img src="${imageUrl}" alt="${post.title}" loading="lazy">
          <p class="date">${new Date(post.published_at).toDateString()}</p>
          <p class="title">${post.title}</p>
        </div>
      `;
    })
    .join("");

  renderPagination(total);
}

function renderPagination(total) {
  const totalPages = Math.ceil(total / perPage);
  pagination.innerHTML = "";

  for (let i = 1; i <= totalPages; i++) {
    const btn = document.createElement("button");
    btn.textContent = i;
    btn.onclick = () => {
      currentPage = i;
      localStorage.setItem("currentPage", currentPage);
      renderPosts();
    };
    if (i === currentPage) btn.classList.add("active");
    pagination.appendChild(btn);
  }
}

perPageSelect.onchange = () => {
  perPage = +perPageSelect.value;
  localStorage.setItem("perPage", perPage);
  currentPage = 1;
  localStorage.setItem("currentPage", currentPage);
  renderPosts();
};

sortSelect.onchange = () => {
  sortOption = sortSelect.value;
  localStorage.setItem("sortBy", sortOption);
  apiSort = sortOption === "newest" ? "-published_at" : "published_at";
  renderPosts();
};

renderPosts();

let prevScrollPos = window.pageYOffset;
const navbar = document.querySelector(".navbar");

window.addEventListener("scroll", () => {
  const currentScrollPos = window.pageYOffset;

  if (currentScrollPos > prevScrollPos) {
    navbar.classList.remove("visible");
    navbar.classList.add("hidden");
  } else {
    navbar.classList.remove("hidden");
    navbar.classList.add("visible");
  }

  if (currentScrollPos === 0) {
    navbar.classList.remove("transparent");
    navbar.classList.add("solid");
  } else {
    navbar.classList.remove("solid");
    navbar.classList.add("transparent");
  }

  prevScrollPos = currentScrollPos;
});

const links = document.querySelectorAll(".menu a");
const currentPath = window.location.pathname.split("/").pop();

links.forEach((link) => {
  const linkPath = link.getAttribute("href");
  if (linkPath === currentPath) {
    link.classList.add("active");
  }
});

window.addEventListener("scroll", () => {
  const heroImg = document.querySelector(".hero-img");
  const scrolled = window.scrollY;
  heroImg.style.transform = `translateY(${scrolled * 0.3}px)`;
});
