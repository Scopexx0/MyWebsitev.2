// When the page is fully loaded, will run.
window.onload = async function() {
    console.debug("page is ready!");
    try {
        const response = await fetch('selectAll.php');
        if (!response.ok) {
            throw new Error('Failed to fetch games');
        }

        const games = await response.json();
        const gamesContainer = document.querySelector('#gamesContainer');

        // Render all games
        gamesContainer.innerHTML = '';
        games.forEach(game => renderGame(game, gamesContainer));

        attachFilterSelect();
        
    } catch (error) {
        console.error('Error loading games:', error);
    }

    // Get the button with the ID "reloadDataButton"
    let reloadButton = document.querySelector('#createGameBtn');

    // Register an event listener for the click function
    reloadButton.addEventListener('click', async function(e){
        e.preventDefault();
        // GET the game name and game platform.
        const newGame = document.querySelector("#createInput").value;
        const newPlatform = document.querySelector('input[name="gamePlat"]:checked').value;

        // Preparing the data to send
        const data = new URLSearchParams();
        data.append('gameName', newGame);
        data.append('gamePlat', newPlatform);

        console.log(data.toString);
        try {
            // Send the selected color to the PHP script via POST
            const response = await fetch('createGame.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                  },
                body: data.toString(),
            });

            // Handle the response from the server
            if (!response.ok) {
                throw new Error('Failed to send color selection');
            }

            const result = await response.json();
            const gamesContainer = document.querySelector('#gamesContainer');
            renderGame(result, gamesContainer);

            attachFilterSelect();
            
        } catch (error) {
            console.error('Error:', error);
        }
    });
}

// Render the game into the gamesContainer (html label)
function renderGame(game, gamesContainer) {
    let statusText;
    if (game.started_at == null) {
        statusText = `<input type="radio" name="status" value="started_at"> Started<br>`;
    } else if (game.completed_at == null) {
        statusText = `<input type="radio" name="status" value="completed_at"> Finished<br>`;
    } else{
        statusText = ``;
    }
    const gameDiv = document.createElement('li');
    gameDiv.id = `game-${game.id}`;
    gameDiv.innerHTML = `
        <strong>${game.game_name.toUpperCase()}</strong>
        <p>Platform: ${game.game_platform}</p>
        <p>Status: ${game.status}</p>
        <!-- Print the time when started or finished if not null -->
        ${game.started_at ? `<p>Started: ${game.started_at}</p>` : ''}
        ${game.completed_at ? `<p>Completed: ${game.completed_at}</p>` : ''}

        <!-- Conditional form for updating the game -->
        ${game.status !== 'completed' ? `
            <form action="updateGame.php" method="POST">
                <p>
                    ${statusText}
                    <input type="hidden" name="game" value="${game.game_name}"/>
                    <button id="update_btn" type="submit">Update ${game.game_name.toUpperCase()}</button>
                </p>
            </form>
        ` : ''}

        <!-- Form to delete Game -->
        <form action="deleteGame.php" method="POST">
            <input type="hidden" name="game" value="${game.game_name}"/>
            <button type='submit'>Delete ${game.game_name.toUpperCase()}</button>
        </form>
    `;
    gamesContainer.appendChild(gameDiv);
}

// Function to attach filters to the select dropdown
function attachFilterSelect() {
    const filterSelect = document.querySelector('#filterSelect');

    filterSelect.addEventListener('change', async function(e) {
        e.preventDefault();
        const selectedFilter = filterSelect.value;

        const response = await fetch('filter.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                filter: selectedFilter
            }).toString()
        });
        if (!response.ok) {
            throw new Error('Failed to fetch games');
        }

        const gameItems = await response.json();

        const gamesContainer = document.querySelector('#gamesContainer');
        gamesContainer.innerHTML = '';

        gameItems.forEach(gameItem => {
            const status = gameItem.status;
            console.log(status);
            renderGame(gameItem, gamesContainer);

        });
    });
}
