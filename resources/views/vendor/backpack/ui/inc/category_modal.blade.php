@vite("resources/css/app.css")

<section id="categoryModal"
	class="!hidden !flex w-full h-screen fixed top-0 left-0 z-[9999] items-center justify-center bg-black/40"
	role="dialog" aria-modal="true" aria-labelledby="modalTitle" aria-describedby="modalDesc">

	<div class="bg-white rounded-lg shadow-xl w-[350px] overflow-hidden" role="document">

		<header class="p-4 pt-6 border-b border-gray-200">
			<h3 id="modalTitle" class="text-lg font-bold text-gray-900 m-0">New category</h3>
		</header>

		<form class="p-6" id="categoryForm" autocomplete="off" novalidate>
			<div class="mb-4">
				<label for="categoryName" class="block text-sm font-medium text-gray-700 mb-1">
					Category name <span class="text-red-500" aria-label="required field">*</span>
				</label>
				<input type="text" id="categoryName" name="name" required placeholder="Category name"
					class="form-control mb-4" autocomplete="off" aria-required="true" aria-describedby="nameHelp">
				<p id="nameHelp" class="sr-only">Required field</p>
			</div>

			<div class="mb-4">
				<label for="categoryDescription" class="block text-sm font-medium text-gray-700 mb-1">
					Description <span class="text-red-500" aria-label="required field">*</span>
				</label>
				<textarea id="categoryDescription" name="description" required placeholder="Category description"
					class="form-control mb-4" rows="3" aria-required="true" aria-describedby="descHelp"></textarea>
				<p id="descHelp" class="sr-only">Required field</p>
			</div>

			<div id="errorMessage" class="text-red-500 mb-4 hidden" role="alert" aria-live="assertive"></div>

			<footer class="flex justify-end gap-4 mt-6">
				<button type="button" id="cancelCategoryBtn" class="btn btn-default" onclick="toggleModal()">
					Cancel
				</button>
				<button type="submit" class="btn btn-primary">
					Add
				</button>
			</footer>
		</form>
	</div>
</section>


<script>
	document.addEventListener("DOMContentLoaded", function () {
		let modal = document.getElementById("categoryModal");

		document.body.insertBefore(modal, document.body.firstElementChild);
	});

	function toggleModal() {

		const modal = document.getElementById("categoryModal");

		modal.classList.toggle("!hidden");
		document.body.classList.toggle("overflow-hidden");

	}

	document.getElementById("categoryForm").onsubmit = async function (e) {
		e.preventDefault();

		const name = document.getElementById("categoryName").value.trim();
		const description = document.getElementById("categoryDescription").value.trim();
		const errorMessage = document.getElementById("errorMessage");

		errorMessage.classList.add("hidden");
		errorMessage.textContent = "";

		if (!name || !description) {
			errorMessage.textContent = "Tous les champs sont obligatoires.";
			errorMessage.classList.remove("hidden");
			return;
		}

		fetch("{{ route('admin.categories.quick-add') }}", {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
				"X-CSRF-TOKEN": "{{ csrf_token() }}",
				"Accept": "application/json"
			},
			body: JSON.stringify({ name, description })
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				toggleModal();
				document.getElementById("categoryForm").reset();
				window.location.reload();
			} else {
				errorMessage.textContent = data.message || "Erreur lors de l'ajout.";
				errorMessage.classList.remove("hidden");
			}
		})
		.catch(e => {
			errorMessage.textContent = "Erreur serveur : " + (e.message || "Inconnue");
			errorMessage.classList.remove("hidden");
		});
	};


</script>