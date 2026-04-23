<!-- resources/views/components/notifications.blade.php -->
<div class="notification-container">
    @if(session('success'))
        <div id="successNotification" class="status-message success" role="alert">
            <div class="icon-container success-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="content">
                <p>{{ session('success') }}</p>
            </div>
            <div class="close-btn">
                <button type="button" onclick="dismissMessage('successNotification')">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <div class="progress-bar"></div>
        </div>
    @endif
    <!-- ... autres messages ... -->
</div>