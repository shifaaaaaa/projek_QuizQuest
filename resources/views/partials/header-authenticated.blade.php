<header class="app-header">
    <a class="logo" href="{{ url('/dashboard') }}" style="color: white; font-size: 1.5rem; font-weight: bold; text-decoration: none;">
        QuizQuest
    </a>
    
    <nav style="display: flex; align-items: center; gap: 1.5rem;">
        <span style="color: #7CD9CE; font-weight: 500;">Halo, {{ Auth::user()->name }}!</span>
        
        <a href="{{ url('/browse') }}" style="color: white; text-decoration: none; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;">
            🔍 Browse Quiz
        </a>
        
        <a href="{{ url('/leaderboard') }}" style="color: white; text-decoration: none; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;">
            🏆 Leaderboard
        </a>

        <!-- User Dropdown -->
        <div class="dropdown" style="position: relative; display: inline-block;">
            <button class="dropdown-btn" onclick="toggleDropdown()" style="
                background: rgb(4, 147, 155);
                color: white;
                border: none;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 500;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
                transition: background 0.3s ease, transform 0.1s ease;
                outline: none;
            ">
                 👤
                <span class="dropdown-arrow" style="transition: transform 0.3s ease; color: white; text-decoration: none; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;"></span>
            </button>

            <div id="dropdownMenu" class="dropdown-content" style="
                display: none;
                position: absolute;
                right: 0;
                top: 100%;
                margin-top: 0.5rem;
                background: white;
                min-width: 180px;
                box-shadow: 0 8px 16px rgba(0,0,0,0.2);
                border-radius: 0.5rem;
                z-index: 1000;
                overflow: hidden;
            ">
                <a href="{{ url('/profile') }}" style="
                    color: #374151;
                    padding: 0.75rem 1rem;
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    transition: background 0.3s ease;
                ">
                    👤 Profile
                </a>
                
                <a href="{{ url('/settings') }}" style="
                    color: #374151;
                    padding: 0.75rem 1rem;
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    transition: background 0.3s ease;
                ">
                    ⚙️ Settings
                </a>
                
                <hr style="margin: 0; border: none; border-top: 1px solid #e5e7eb;">
                
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       style="
                           color: #dc2626;
                           padding: 0.75rem 1rem;
                           text-decoration: none;
                           display: flex;
                           align-items: center;
                           gap: 0.5rem;
                           transition: background 0.3s ease;
                           width: 100%;
                           box-sizing: border-box;
                       ">
                        🚪 Logout
                    </a>
                </form>
            </div>
        </div>
    </nav>
</header>

<style>
.dropdown-btn:hover {
    background: rgba(255, 255, 255, 0.2) !important;
}

.dropdown-content a:hover {
    background: #f3f4f6 !important;
}

.dropdown-content a:last-child:hover {
    background: #fef2f2 !important;
}

.dropdown.active .dropdown-arrow {
    transform: rotate(180deg);
}
</style>

<script>
function toggleDropdown() {
    const dropdown = document.getElementById("dropdownMenu");
    const dropdownContainer = dropdown.closest('.dropdown');
    const arrow = dropdownContainer.querySelector('.dropdown-arrow');
    
    if (dropdown.style.display === "none" || dropdown.style.display === "") {
        dropdown.style.display = "block";
        dropdownContainer.classList.add('active');
    } else {
        dropdown.style.display = "none";
        dropdownContainer.classList.remove('active');
    }
}

// Close dropdown when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.dropdown-btn') && !event.target.closest('.dropdown-btn')) {
        const dropdowns = document.getElementsByClassName("dropdown-content");
        const dropdownContainers = document.getElementsByClassName("dropdown");
        
        for (let i = 0; i < dropdowns.length; i++) {
            dropdowns[i].style.display = "none";
        }
        
        for (let i = 0; i < dropdownContainers.length; i++) {
            dropdownContainers[i].classList.remove('active');
        }
    }
}
</script>