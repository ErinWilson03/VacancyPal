{{-- Name --}}
<div class="mt-2">
    <x-ui.form.input label="Applicant Name" name="name" type="text" />
</div>

{{-- Contact Information --}}
<div class="flex gap-4 mt-4">
    <div class="w-1/2">
        <x-ui.form.input label="Email Address" name="email" type="text" />
    </div>
    <div class="w-1/2">
        <x-ui.form.input label="Mobile Number" name="mobile_number" type="text" />
    </div>
</div>

{{-- Supporting Statement --}}
<div class="mt-4">
    <x-ui.form.textarea label="Supporting Statement" name="supporting_statement" rows="6"
        id="supporting_statement" oninput="updateCharacterCount()"></x-ui.form.textarea>

    <div class="mt-2 text-sm text-gray-500">
        <span id="char_count">0</span> / 500 characters
    </div>
</div>

<div class="mt-4">
    <label for="cv" class="block text-gray-700 text-sm font-bold uppercase">Upload CV (PDF, DOC, DOCX)</label>
    <input type="file" name="cv" id="cv" class="mt-1 border border-gray-300 p-2 rounded-md w-full"
        accept=".pdf, .doc, .docx" onchange="previewFile(); checkFileSize();">
    <div id="cv-preview" class="mt-4">
        <!-- Preview of the user's CV will show here -->
    </div>

    <!-- Warn the user if file exceeds accepted size -->
    <div id="file-size-warning" class="mt-2 text-red-500 text-sm hidden">
        <p>The selected file exceeds the 2MB size limit. Please upload a smaller file.</p>
    </div>
</div>

<script>
    // Script to manage the character count for supporting statement
    function updateCharacterCount() {
        const textarea = document.getElementById('supporting_statement');
        const charCount = document.getElementById('char_count');
        const maxLength = 500; // Set the maximum character limit

        // Update the character count
        charCount.textContent = textarea.value.length;

        // Logic to warn when the limit is close or exceeded
        if (textarea.value.length > maxLength) {
            charCount.classList.add('text-red-500');
        } else {
            charCount.classList.remove('text-red-500');
        }
    }


    // Script to preview CV
    function previewFile() {
        const fileInput = document.getElementById('cv');
        const file = fileInput.files[0];
        const preview = document.getElementById('cv-preview');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.innerHTML = `<embed src="${e.target.result}" width="100%" height="400px" />`;
            }

            reader.readAsDataURL(file);
        }
    }

    //Script to check the CV's file size
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB in bytes

    function checkFileSize() {
        const fileInput = document.getElementById('cv');
        const file = fileInput.files[0];
        const warningMessage = document.getElementById('file-size-warning');

        if (file && file.size > MAX_FILE_SIZE) {
            warningMessage.classList.remove('hidden');
        } else {
            warningMessage.classList.add('hidden');
        }
    }
</script>
