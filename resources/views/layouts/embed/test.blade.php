<div style="width: 500px;">

    <div style="
        width: 100%;
        height: 30px;
        background: #ddd;
    ">
        <div
            id="progressBar"
            style="
                width: 0%;
                height: 30px;
                background: #3498db;
                color: white;
                text-align: center;
                line-height: 30px;
                transition: width 0.3s;
            "
        >
            0%
        </div>
    </div>

    <br>

    <button onclick="startProcess()">
        Start
    </button>

</div>

<script>

function updateProgress(percent)
{
    const bar = document.getElementById('progressBar');

    bar.style.width = percent + '%';
    bar.textContent = percent + '%';
}


async function startProcess()
{
    updateProgress(0);

    // Start PHP process
    fetch("{{ route('traffic.start') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    });
 
    checkProgress();
}


async function checkProgress()
{
    try {

        const response = await fetch(
            "{{ route('progress') }}?t=" + Date.now()
        );
       
        const data = await response.json(); 
        const percent = Number(data.progress);

        updateProgress(percent);

        if (percent < 100) {
            setTimeout(checkProgress, 500);
        }

    } catch (error) {
        console.error(error);

        setTimeout(checkProgress, 500);
    }
}
</script>