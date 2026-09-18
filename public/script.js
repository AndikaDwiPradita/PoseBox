/* ============================================================
   POSEBOX - STRIP LANGSUNG MUNCUL SAAT TEMPLATE DIPILIH
============================================================ */

// ============================================================
// 1. KAMERA, TIMER, FILTER, TEMA
// ============================================================

let stream;
let currentMode = "user";
const video = document.getElementById("video");

async function bukaKamera(mode) {
  if (stream) {
    stream.getTracks().forEach(track => track.stop());
  }
  try {
    stream = await navigator.mediaDevices.getUserMedia({
      video: { facingMode: mode },
      audio: false
    });
    video.srcObject = stream;
    await video.play();
    applyMirror();
  } catch (err) {
    alert(err.message);
  }
}

function gantiKamera() {
  currentMode = currentMode === "user" ? "environment" : "user";
  bukaKamera(currentMode);
}

function applyMirror() {
  if (currentMode === "user") {
    video.style.transform = "scaleX(-1)";
  } else {
    video.style.transform = "scaleX(1)";
  }
}

bukaKamera(currentMode);

// Timer
let selectedTimer = 3;
const countdownEl = document.getElementById("countdown");
const timerButtons = document.querySelectorAll(".timer button");

function setActiveButton(id) {
  timerButtons.forEach(btn => btn.classList.remove("active"));
  document.getElementById(id).classList.add("active");
}

document.getElementById("s3").onclick = () => { selectedTimer = 3; setActiveButton("s3"); };
document.getElementById("s5").onclick = () => { selectedTimer = 5; setActiveButton("s5"); };
document.getElementById("s10").onclick = () => { selectedTimer = 10; setActiveButton("s10"); };
setActiveButton("s3");

// Settings
const settingsPopup = document.getElementById("settingsPopup");
const flashToggle = document.getElementById("flashToggle");
const soundToggle = document.getElementById("soundToggle");
let flashEnabled = true;
let soundEnabled = true;

function settings() {
  settingsPopup.style.display = "flex";
}
document.querySelector("#settingsPopup .popup-content button:last-child").onclick = () => {
  settingsPopup.style.display = "none";
};

flashToggle.addEventListener("change", () => { flashEnabled = flashToggle.checked; });
soundToggle.addEventListener("change", () => { soundEnabled = soundToggle.checked; });

// Filter
function openFilterPopup() {
  document.getElementById("filterPopup").style.display = "flex";
}
function setFilter(filter) {
  video.style.filter = filter;
  document.getElementById("filterPopup").style.display = "none";
}

// Tema
function openTemaPopup() {
  document.getElementById("temaPopup").style.display = "flex";
}
function pilihTema(tema) {
  if (tema === "creammaroon") {
    document.body.classList.add("tema-creammaroon");
    document.body.classList.remove("tema-pink");
    localStorage.setItem("tema", "creammaroon");
  } else {
    document.body.classList.add("tema-pink");
    document.body.classList.remove("tema-creammaroon");
    localStorage.setItem("tema", "pink");
  }
  document.getElementById("temaPopup").style.display = "none";
}
document.body.classList.add(localStorage.getItem("tema") || "tema-pink");

// ============================================================
// 2. SIDEBAR TOGGLE
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
  const hamburger = document.getElementById('hamburgerBtn');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const closeBtn = document.getElementById('closeSidebar');

  if (hamburger) {
    hamburger.addEventListener('click', function() {
      sidebar.classList.toggle('open');
      overlay.classList.toggle('active');
    });
  }
  if (closeBtn) {
    closeBtn.addEventListener('click', function() {
      sidebar.classList.remove('open');
      overlay.classList.remove('active');
    });
  }
  if (overlay) {
    overlay.addEventListener('click', function() {
      sidebar.classList.remove('open');
      overlay.classList.remove('active');
    });
  }
});

// ============================================================
// 3. SISTEM TEMPLATE (5 TEMPLATE + THUMBNAIL + STICKER)
// ============================================================

const templates = [
  {
    id: 'template-1',
    name: 'Template 1 (Pink)',
    thumbnail: 'assets/templates/template-1/thumbnail.png',
    bgImage: 'assets/templates/template-1/background.png',
    stickerImage: 'assets/templates/template-1/sticker.png',
    bgColor: '#ffe4ec',
    textColor: '#b34180',
    canvasWidth: 800,
    canvasHeight: 1890,
    maxPhotos: 3,
    frames: [
      { x: 50, y: 140, w: 700, h: 540 },
      { x: 50, y: 710, w: 700, h: 540 },
      { x: 50, y: 1280, w: 700, h: 540 }
    ]
  },
  {
    id: 'template-2',
    name: 'Template 2 (Dark)',
    thumbnail: 'assets/templates/template-2/thumbnail.png',
    bgImage: 'assets/templates/template-2/background.png',
    stickerImage: 'assets/templates/template-2/sticker.png',
    bgColor: '#1a1a2e',
    textColor: '#eee',
    canvasWidth: 800,
    canvasHeight: 1890,
    maxPhotos: 3,
    frames: [
      { x: 50, y: 140, w: 700, h: 540 },
      { x: 50, y: 710, w: 700, h: 540 },
      { x: 50, y: 1280, w: 700, h: 540 }
    ]
  },
  {
    id: 'template-3',
    name: 'Template 3 (Retro)',
    thumbnail: 'assets/templates/template-3/thumbnail.png',
    bgImage: 'assets/templates/template-3/background.png',
    stickerImage: 'assets/templates/template-3/sticker.png',
    bgColor: '#f4e1c1',
    textColor: '#6b3e1f',
    canvasWidth: 800,
    canvasHeight: 1890,
    maxPhotos: 3,
    frames: [
      { x: 50, y: 140, w: 700, h: 540 },
      { x: 50, y: 710, w: 700, h: 540 },
      { x: 50, y: 1280, w: 700, h: 540 }
    ]
  },
  {
    id: 'template-4',
    name: 'Template 4 (Minimal)',
    thumbnail: 'assets/templates/template-4/thumbnail.png',
    bgImage: 'assets/templates/template-4/background.png',
    stickerImage: 'assets/templates/template-4/sticker.png',
    bgColor: '#ffffff',
    textColor: '#222',
    canvasWidth: 800,
    canvasHeight: 1890,
    maxPhotos: 3,
    frames: [
      { x: 50, y: 140, w: 700, h: 540 },
      { x: 50, y: 710, w: 700, h: 540 },
      { x: 50, y: 1280, w: 700, h: 540 }
    ]
  },
  {
    id: 'template-5',
    name: 'Template 5 (Canva Gradient)',
    thumbnail: 'assets/templates/template-5/thumbnail.png',
    bgImage: 'assets/templates/template-5/background.png',
    stickerImage: 'assets/templates/template-5/sticker.png',
    bgColor: '#fdebf7',
    textColor: '#2d3436',
    canvasWidth: 800,
    canvasHeight: 1890,
    maxPhotos: 3,
    frames: [
      { x: 50, y: 140, w: 700, h: 540 },
      { x: 50, y: 710, w: 700, h: 540 },
      { x: 50, y: 1280, w: 700, h: 540 }
    ]
  }
];

// State
let photos = [];
let selectedTemplateId = templates[0]?.id || null;
const resultCanvas = document.getElementById('resultCanvas');
const previewOverlay = document.getElementById('previewOverlay');
const photoSlots = document.getElementById('photoSlots');
const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('fileInput');
const btnDownloadPNG = document.getElementById('btnDownloadPNG');
const btnDownloadJPG = document.getElementById('btnDownloadJPG');
const selectedTemplateName = document.getElementById('selectedTemplateName');

// ============================================================
// 4. FUNGSI TEMPLATE
// ============================================================

function getTemplate(id) {
  return templates.find(t => t.id === id);
}

function loadImage(src) {
  return new Promise((resolve, reject) => {
    const img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = () => resolve(img);
    img.onerror = () => reject(new Error(`Gagal memuat: ${src}`));
    img.src = src;
  });
}

function renderSlots() {
  photoSlots.innerHTML = '';
  photos.forEach((src, i) => {
    const div = document.createElement('div');
    div.className = 'slot-item';
    div.innerHTML = `
      <img src="${src}">
      <span class="slot-index">${i+1}</span>
      <button class="slot-remove" data-index="${i}">✕</button>
    `;
    div.querySelector('.slot-remove').addEventListener('click', (e) => {
      e.stopPropagation();
      removePhoto(i);
    });
    photoSlots.appendChild(div);
  });
}

function removePhoto(index) {
  photos.splice(index, 1);
  renderSlots();
  if (photos.length > 0) {
    buatStrip();
  } else {
    renderTemplateOnly();
  }
}

function addPhoto(imageData) {
  const template = getTemplate(selectedTemplateId);
  const maxPhotos = template?.maxPhotos || 3;
  if (photos.length >= maxPhotos) {
    alert(`Maksimal ${maxPhotos} foto!`);
    return;
  }
  photos.push(imageData);
  renderSlots();
  buatStrip();
}

// ============================================================
// 5. RENDER TEMPLATE TANPA FOTO
// ============================================================
async function renderTemplateOnly() {
  const template = getTemplate(selectedTemplateId);
  if (!template) return;

  const W = template.canvasWidth;
  const H = template.canvasHeight;

  resultCanvas.width = W;
  resultCanvas.height = H;
  const ctx = resultCanvas.getContext('2d');

  // Background
  ctx.clearRect(0, 0, W, H);
  if (template.bgImage) {
    try {
      const bgImg = await loadImage(template.bgImage);
      ctx.drawImage(bgImg, 0, 0, W, H);
    } catch (e) {
      ctx.fillStyle = template.bgColor || '#ffffff';
      ctx.fillRect(0, 0, W, H);
    }
  } else {
    ctx.fillStyle = template.bgColor || '#ffffff';
    ctx.fillRect(0, 0, W, H);
  }

  // Judul
  ctx.fillStyle = template.textColor;
  ctx.font = "bold 44px 'Poppins', sans-serif";
  ctx.textAlign = "center";
  ctx.fillText("PoseBox", W / 2, 70);

  // Slot kosong (dashed border)
  for (let i = 0; i < template.frames.length; i++) {
    const frame = template.frames[i];
    ctx.save();
    ctx.strokeStyle = 'rgba(255,255,255,0.3)';
    ctx.lineWidth = 2;
    ctx.setLineDash([5, 5]);
    ctx.strokeRect(frame.x, frame.y, frame.w, frame.h);
    ctx.restore();

    ctx.fillStyle = 'rgba(255,255,255,0.15)';
    ctx.font = '20px Poppins';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(`📷 Slot ${i+1}`, frame.x + frame.w/2, frame.y + frame.h/2);
  }

  // Sticker
  if (template.stickerImage) {
    try {
      const stickerImg = await loadImage(template.stickerImage);
      ctx.drawImage(stickerImg, 0, 0, W, H);
    } catch (e) {}
  }

  // Footer
  const today = new Date().toLocaleDateString("id-ID", {
    day: 'numeric', month: 'long', year: 'numeric'
  });
  ctx.font = "italic 16px 'Poppins'";
  ctx.fillStyle = template.textColor;
  ctx.fillText(`dicapture • ${today}`, W / 2, H - 35);

  resultCanvas.classList.add('active');
  previewOverlay.style.display = 'none';
}

// ============================================================
// 6. RENDER STRIP DENGAN FOTO (Background → Foto → Sticker)
// ============================================================
async function buatStrip() {
  const template = getTemplate(selectedTemplateId);
  if (!template) return;

  const W = template.canvasWidth;
  const H = template.canvasHeight;

  resultCanvas.width = W;
  resultCanvas.height = H;
  const ctx = resultCanvas.getContext('2d');

  // 1. BACKGROUND
  ctx.clearRect(0, 0, W, H);
  if (template.bgImage) {
    try {
      const bgImg = await loadImage(template.bgImage);
      ctx.drawImage(bgImg, 0, 0, W, H);
    } catch (e) {
      ctx.fillStyle = template.bgColor || '#ffffff';
      ctx.fillRect(0, 0, W, H);
    }
  } else {
    ctx.fillStyle = template.bgColor || '#ffffff';
    ctx.fillRect(0, 0, W, H);
  }

  // 2. FOTO
  for (let i = 0; i < template.frames.length && i < photos.length; i++) {
    const frame = template.frames[i];
    const img = new Image();
    img.src = photos[i];
    await new Promise((resolve) => {
      img.onload = () => {
        const maxW = frame.w;
        const maxH = frame.h;
        let w = img.width;
        let h = img.height;
        if (w > maxW) { h = (h * maxW) / w; w = maxW; }
        if (h > maxH) { w = (w * maxH) / h; h = maxH; }
        const x = frame.x + (maxW - w) / 2;
        const y = frame.y + (maxH - h) / 2;

        ctx.save();
        ctx.shadowColor = "rgba(0,0,0,0.15)";
        ctx.shadowBlur = 12;
        ctx.fillStyle = "#fff";
        ctx.fillRect(x - 12, y - 12, w + 24, h + 24);
        ctx.shadowBlur = 0;
        ctx.drawImage(img, x, y, w, h);
        ctx.restore();

        ctx.font = "bold 20px 'Poppins'";
        ctx.fillStyle = template.textColor;
        ctx.fillText(`${i + 1}`, x + 15, y + 35);
        resolve();
      };
      img.onerror = () => resolve();
    });
  }

  // 3. STICKER
  if (template.stickerImage) {
    try {
      const stickerImg = await loadImage(template.stickerImage);
      ctx.drawImage(stickerImg, 0, 0, W, H);
    } catch (e) {
      console.warn('Sticker tidak ditemukan, lanjut tanpa sticker.', e);
    }
  }

  // 4. FOOTER
  const today = new Date().toLocaleDateString("id-ID", {
    day: 'numeric', month: 'long', year: 'numeric'
  });
  ctx.font = "italic 16px 'Poppins'";
  ctx.fillStyle = template.textColor;
  ctx.fillText(`dicapture • ${today}`, W / 2, H - 35);

  resultCanvas.classList.add('active');
  previewOverlay.style.display = 'none';
}

// ============================================================
// 7. SELECT TEMPLATE
// ============================================================
function selectTemplate(id) {
  const template = getTemplate(id);
  if (!template) return;
  selectedTemplateId = id;
  if (selectedTemplateName) {
    selectedTemplateName.textContent = template.name;
  }
  document.getElementById('templatePopup').style.display = 'none';

  if (photos.length > 0) {
    buatStrip();
  } else {
    renderTemplateOnly();
  }
}

// ============================================================
// 8. DOWNLOAD
// ============================================================
function download(type = 'png') {
  if (!resultCanvas.classList.contains('active')) {
    alert('Buat hasil dulu!');
    return;
  }
  const mime = type === 'jpg' ? 'image/jpeg' : 'image/png';
  const ext = type === 'jpg' ? 'jpg' : 'png';
  const link = document.createElement('a');
  link.download = `posebox.${ext}`;
  link.href = resultCanvas.toDataURL(mime, 0.95);
  link.click();
}

// ============================================================
// 9. EVENT BINDING
// ============================================================

uploadArea.addEventListener('click', () => fileInput.click());
fileInput.addEventListener('change', (e) => {
  const files = e.target.files;
  const valid = Array.from(files).filter(f => f.type.startsWith('image/'));
  if (valid.length === 0) return;

  const template = getTemplate(selectedTemplateId);
  const maxPhotos = template?.maxPhotos || 3;
  const remaining = maxPhotos - photos.length;

  if (remaining <= 0) {
    alert(`Maksimal ${maxPhotos} foto!`);
    return;
  }

  const filesToAdd = valid.slice(0, remaining);
  if (valid.length > remaining) {
    alert(`Hanya ${remaining} foto yang bisa ditambahkan.`);
  }

  filesToAdd.forEach(file => {
    const reader = new FileReader();
    reader.onload = (e) => {
      addPhoto(e.target.result);
    };
    reader.readAsDataURL(file);
  });
  fileInput.value = '';
});

btnDownloadPNG.addEventListener('click', () => download('png'));
btnDownloadJPG.addEventListener('click', () => download('jpg'));

// ============================================================
// 10. TEMPLATE POPUP
// ============================================================

async function openTemplatePopup() {
  const popup = document.getElementById('templatePopup');
  const grid = document.getElementById('templateGrid');
  if (!popup || !grid) return;

  grid.innerHTML = '';
  for (const tpl of templates) {
    const item = document.createElement('div');
    item.className = 'template-item';
    if (selectedTemplateId === tpl.id) item.classList.add('selected');

    const thumb = document.createElement('img');
    thumb.loading = 'lazy';
    thumb.src = tpl.thumbnail || tpl.bgImage || '';
    thumb.alt = tpl.name;
    thumb.style.width = '100%';
    thumb.style.aspectRatio = '1/1.2';
    thumb.onerror = () => {
      thumb.style.display = 'none';
      const fallbackDiv = document.createElement('div');
      fallbackDiv.style.cssText = `
        width: 100%;
        aspect-ratio: 1/1.2;
        border-radius: 10px;
        background: ${tpl.bgColor || '#eee'};
        display: flex;
        align-items: center;
        justify-content: center;
        color: ${tpl.textColor || '#333'};
        font-size: 0.7rem;
        font-weight: bold;
      `;
      fallbackDiv.textContent = tpl.name;
      item.prepend(fallbackDiv);
    };

    const name = document.createElement('div');
    name.className = 'template-name';
    name.textContent = tpl.name;

    item.appendChild(thumb);
    item.appendChild(name);

    item.addEventListener('click', () => {
      selectTemplate(tpl.id);
      grid.querySelectorAll('.template-item').forEach(el => el.classList.remove('selected'));
      item.classList.add('selected');
    });

    grid.appendChild(item);
  }

  popup.style.display = 'flex';
}

function closeTemplatePopup() {
  document.getElementById('templatePopup').style.display = 'none';
}

const btnOpenTemplate = document.getElementById('btnOpenTemplate');
if (btnOpenTemplate) {
  btnOpenTemplate.addEventListener('click', openTemplatePopup);
}

// ============================================================
// 11. INTEGRASI KAMERA
// ============================================================

let isTakingPhoto = false;

window.takeFoto = async function() {
  if (isTakingPhoto) return;
  isTakingPhoto = true;

  let timeLeft = selectedTimer;
  countdownEl.style.display = 'block';
  countdownEl.innerText = timeLeft;

  const timer = setInterval(() => {
    timeLeft--;
    if (timeLeft > 0) {
      countdownEl.innerText = timeLeft;
    } else {
      clearInterval(timer);
      countdownEl.style.display = 'none';

      if (flashEnabled) {
        const flash = document.getElementById('flash');
        flash.style.opacity = '1';
        setTimeout(() => { flash.style.opacity = '0'; }, 100);
      }
      if (soundEnabled) {
        document.getElementById('shutter').play().catch(() => {});
      }

      const canvas = document.createElement('canvas');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      const ctx = canvas.getContext('2d');

      if (currentMode === 'user') {
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
      }
      ctx.filter = video.style.filter;
      ctx.drawImage(video, 0, 0);
      const imageData = canvas.toDataURL('image/png');

      addPhoto(imageData);

      isTakingPhoto = false;
    }
  }, 1000);
};

// ============================================================
// 12. TUTUP POPUP DENGAN KLIK DI LUAR
// ============================================================

document.querySelectorAll('.popup').forEach(popup => {
  popup.addEventListener('click', function(e) {
    if (this.style.display === 'flex' && e.target === this) {
      this.style.display = 'none';
    }
  });
});

// ============================================================
// 13. INISIALISASI AWAL
// ============================================================

// Tema
const savedTema = localStorage.getItem('tema') || 'pink';
if (savedTema === 'creammaroon') {
  document.body.classList.add('tema-creammaroon');
} else {
  document.body.classList.add('tema-pink');
}

// Pilih template pertama & render tanpa foto
if (templates.length > 0 && !selectedTemplateId) {
  selectTemplate(templates[0].id);
} else if (selectedTemplateId) {
  const tpl = getTemplate(selectedTemplateId);
  if (tpl && selectedTemplateName) {
    selectedTemplateName.textContent = tpl.name;
  }
  if (photos.length > 0) {
    buatStrip();
  } else {
    renderTemplateOnly();
  }
}

// // ==========================================
// UPDATE NAVBAR BERDASARKAN STATUS LOGIN
// ==========================================
function updateNavbarUI() {
  const token = localStorage.getItem('token');
  const user = JSON.parse(localStorage.getItem('user') || 'null');

  const authSection = document.getElementById('authSection');
  const userSection = document.getElementById('userSection');
  const avatar = document.getElementById('navAvatar');
  const userName = document.getElementById('navUserName');

  if (token && user) {
    if (authSection) authSection.style.display = 'none';
    if (userSection) userSection.style.display = 'flex';

    if (userName) {
      userName.textContent = user.name || user.email?.split('@')[0] || 'User';
    }

    if (avatar) {
      avatar.src = 'assets/default-avatar.png';
    }
  } // ✅ Tutup if (token && user)
} // ✅ Tutup fungsi updateNavbarUI

// ✅ Sekarang kode ini berada di luar fungsi
document.addEventListener('DOMContentLoaded', function() {
  updateNavbarUI();
});

window.updateNavbarUI = updateNavbarUI;

function logout() {
  if (confirm('Yakin mau logout?')) {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    window.location.href = 'index.html';
  }
}