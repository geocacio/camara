<script>
    function toggleVisibility({target}, id, url) {
        let visibility = target.checked ? 'enabled' : 'disabled';

        let requestData = {
            id: id,
            visibility: visibility
        };

        const csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        axios.post(url, requestData, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf_token,
                    "Content-Type": "multipart/form-data",
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (checkIfRunningInterval()) {
                    stopProgress();
                }
                const toast = document.querySelector('.toast');
                toast.querySelector('.message').innerHTML = response.data.message;

                startProgress();
            })
            .catch(error => {
                const toast = document.querySelector('.toast');
                toast.classList.add('show', 'error');
                toast.querySelector('.message').innerHTML = error.data.message;
                console.log(toast)
                setTimeout(() => {
                    toast.classList.remove('show', 'error');
                }, 3000);
            });
    }
    let hideMessage;

    function startProgress() {
        const toast = document.querySelector('.toast');
        toast.classList.add('show', 'success');
        const progress = document.querySelector('.progress-close');
        progress.style.width = `0%`;

        let width = 0;
        hideMessage = setInterval(() => {
            width++;
            progress.style.width = `${width}%`;
            if (width >= 100) {
                toast.classList.remove('show', 'success');
                clearInterval(hideMessage);
                hideMessage = null;
            }
        }, 30);
    }

    function checkIfRunningInterval() {
        return hideMessage;
    }

    function stopProgress() {
        clearInterval(hideMessage);
    }
</script>