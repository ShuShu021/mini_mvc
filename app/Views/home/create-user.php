<!-- Formulaire pour créer un nouvel utilisateur -->
<div class="container" style="max-width: 600px;">
    <h2>Ajouter un nouvel utilisateur</h2>
    
    <!-- Message de succès ou d'erreur -->
    <div id="message" class="message" style="display: none;"></div>
    
    <form id="userForm">
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input 
                type="text" 
                id="nom" 
                name="nom" 
                required 
                placeholder="Entrez le nom de l'utilisateur"
            >
        </div>
        
        <div class="form-group">
            <label for="email">Email :</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                required 
                placeholder="exemple@email.com"
            >
        </div>
        
        <button type="submit" class="btn btn-primary">
            Créer l'utilisateur
        </button>
    </form>
    
    <div class="mt-20">
        <a href="/">← Retour à l'accueil</a>
    </div>
</div>

<script>
// Gestion de la soumission du formulaire
document.getElementById('userForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Récupère les valeurs du formulaire
    const nom = document.getElementById('nom').value.trim();
    const email = document.getElementById('email').value.trim();
    
    // Affiche un message de chargement
    const messageDiv = document.getElementById('message');
    messageDiv.style.display = 'block';
    messageDiv.style.backgroundColor = '#d1ecf1';
    messageDiv.style.color = '#0c5460';
    messageDiv.textContent = 'Création en cours...';
    
    try {
        // Envoie la requête POST avec les données en JSON
        const response = await fetch('/users', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                nom: nom,
                email: email
            })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            // Succès
            messageDiv.style.backgroundColor = '#d4edda';
            messageDiv.style.color = '#155724';
            messageDiv.textContent = '✅ ' + data.message;
            
            // Réinitialise le formulaire
            document.getElementById('userForm').reset();
        } else {
            // Erreur
            messageDiv.style.backgroundColor = '#f8d7da';
            messageDiv.style.color = '#721c24';
            messageDiv.textContent = '❌ ' + (data.error || 'Une erreur est survenue');
        }
    } catch (error) {
        // Erreur réseau
        messageDiv.style.backgroundColor = '#f8d7da';
        messageDiv.style.color = '#721c24';
        messageDiv.textContent = '❌ Erreur de connexion : ' + error.message;
    }
});
</script>

