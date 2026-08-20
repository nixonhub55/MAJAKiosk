window.addEventListener('error', (event) => {
  fetch('/log-client-error.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      message: event.message,
      stack: event.error?.stack
    })
  });
});