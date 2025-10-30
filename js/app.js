const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container1");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

function loadModal(modelId) {
  // جلب محتوى صفحة الموديلات
  fetch('modals.html')
    .then(response => response.text())
    .then(html => {
      // إنشاء عنصر مؤقت لاحتواء محتوى الموديلات
      const tempDiv = document.createElement('div');
      tempDiv.innerHTML = html;

      // استخراج الموديل المطلوب
      const selectedModal = tempDiv.querySelector(`#${modelId}`);
      if (selectedModal) {
        // وضع الموديل في الصفحة الرئيسية
        const modalContainer = document.getElementById('modalContainer');
        modalContainer.innerHTML = ''; // مسح أي موديل قديم
        modalContainer.appendChild(selectedModal);

        // تهيئة الموديل باستخدام Bootstrap
        const modal = new bootstrap.Modal(selectedModal);
        modal.show();
      }
    })
    .catch(error => {
      console.error('خطأ في جلب الموديل:', error);
    });
}


function loadModal(modelId) {
  // جلب محتوى صفحة الموديلات
  fetch('../modals.html')
    .then(response => response.text())
    .then(html => {
      // إنشاء عنصر مؤقت لاحتواء محتوى الموديلات
      const tempDiv = document.createElement('div');
      tempDiv.innerHTML = html;

      // استخراج الموديل المطلوب
      const selectedModal = tempDiv.querySelector(`#${modelId}`);
      if (selectedModal) {
        // وضع الموديل في الصفحة الرئيسية
        const modalContainer = document.getElementById('modalContainer');
        modalContainer.innerHTML = ''; // مسح أي موديل قديم
        modalContainer.appendChild(selectedModal);

        // تهيئة الموديل باستخدام Bootstrap
        const modal = new bootstrap.Modal(selectedModal);
        modal.show();
      }
    })
    .catch(error => {
      console.error('خطأ في جلب الموديل:', error);
    });
}
