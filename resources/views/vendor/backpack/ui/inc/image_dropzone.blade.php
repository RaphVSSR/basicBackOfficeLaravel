<section id="image-dropzone"
	class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-[rgba(var(--evian-bleu-rgb),0.5)] transition-opacity duration-200 opacity-0 pointer-events-none">
	<div class="w-full max-w-4xl mx-auto flex flex-col items-center justify-center">
		<div id="popup-content"
			class="flex flex-col items-center px-16 py-20 rounded-[2.5rem] shadow-2xl transition-transform duration-200 scale-95 bg-[var(--evian-blanc)]">
			<span
				class="mb-10 select-none text-[5rem] leading-none text-[var(--evian-gris-clair)] font-sans animate-bounce"
				aria-hidden="true">
				🖼️
			</span>
			<h2
				class="text-3xl md:text-4xl font-semibold text-center tracking-tight text-[var(--evian-bleu)] font-sans">
				Déposez votre image ici
			</h2>
		</div>
	</div>
</section>
<input type="file" id="popupFileInput" accept="image/*" class="hidden" />

<script>
	document.addEventListener("DOMContentLoaded", function () {
		let popup = document.getElementById("image-dropzone");
		if (popup && popup.parentNode !== document.body) {
			document.body.insertBefore(popup, document.body.firstElementChild);
		}
		let fileInput = document.getElementById("popupFileInput");
		if (fileInput && fileInput.parentNode !== document.body) {
			document.body.insertBefore(fileInput, document.body.firstElementChild.nextSibling);
		}

		function showPopup() {
			popup.style.display = "flex";
			setTimeout(() => {
				popup.classList.remove("opacity-0", "pointer-events-none");
				popup.classList.add("opacity-100");
				document.getElementById("popup-content").classList.add("scale-100");
			}, 10);
		}
		function hidePopup() {
			popup.classList.add("opacity-0");
			popup.classList.remove("opacity-100");
			setTimeout(() => {
				popup.style.display = "none";
			}, 200);
		}

		let dragActive = false;
		let dragLeaveTimeout = null;

		document.addEventListener("dragenter", function (e) {
			if (e.dataTransfer && e.dataTransfer.types.includes("Files")) {
				dragActive = true;
				showPopup();
				if (dragLeaveTimeout) clearTimeout(dragLeaveTimeout);
			}
		});
		document.addEventListener("dragover", function (e) {
			if (e.dataTransfer && e.dataTransfer.types.includes("Files")) {
				dragActive = true;
				showPopup();
				e.preventDefault();
			}
		});
		document.addEventListener("dragleave", function (e) {
			if (e.relatedTarget === null || e.relatedTarget === document.body) {
				dragLeaveTimeout = setTimeout(() => {
					dragActive = false;
					hidePopup();
				}, 100);
			}
		});
		document.addEventListener("drop", function (e) {
			dragActive = false;
			hidePopup();
		});

		document.body.addEventListener("drop", function (e) {
			if (popup && popup.style.display !== "none" && popup.contains(e.target)) {
				e.preventDefault();
				hidePopup();
				const files = e.dataTransfer.files;
				if (files && files.length > 0) {
					setImageInputFile(files[0]);
				}
			}
		});

		function setImageInputFile(file) {
			let fileInputs = document.querySelectorAll('input[type="file"][name="image_src"]');
			fileInputs.forEach(function (input) {
				const dt = new DataTransfer();
				dt.items.add(file);
				input.files = dt.files;
				input.dispatchEvent(new Event("change", { bubbles: true }));
			});
		}
	});
</script>