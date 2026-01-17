# Documentation API - Meditation App

## Base URL
```
http://localhost:8000/api
```

## Table des matières
1. [Authentification](#authentification)
2. [Utilisateurs](#utilisateurs)
3. [Méditations](#méditations)
4. [Affirmations](#affirmations)
5. [Événements](#événements)
6. [Blogs](#blogs)
7. [Plans de retraite](#plans-de-retraite)
8. [Journaux de gratitude](#journaux-de-gratitude)
9. [Formulaire Food Comfort](#formulaire-food-comfort)
10. [Paiements](#paiements)

---

## Authentification

### Enregistrement temporaire (Onboarding)
Permet à un utilisateur de créer un compte temporaire via l'onboarding mobile sans email/mot de passe.

**Endpoint:** `POST /auth/register-temporary`

**Headers:**
```
Content-Type: application/json
```

**Body:**
```json
{
  "name": "Jean Dupont",
  "date_of_birth": "1990-05-15",
  "gender": "male",
  "device_id": "unique-device-id-12345",
  "objectives": [1, 3, 5]
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "Utilisateur enregistré avec succès",
  "data": {
    "user": {
      "id": 1,
      "name": "Jean Dupont",
      "email": null,
      "date_of_birth": "1990-05-15",
      "gender": "male",
      "device_id": "unique-device-id-12345",
      "is_premium": false,
      "role": "user"
    },
    "token": "1|abcdef123456..."
  }
}
```

---

### Connexion
Permet à un utilisateur de se connecter avec email et mot de passe.

**Endpoint:** `POST /login`

**Headers:**
```
Content-Type: application/json
```

**Body:**
```json
{
  "email": "jean.dupont@email.com",
  "password": "motdepasse123"
}
```

**Response (200):**
```json
{
  "success": true,
  "token": "2|xyz789...",
  "user": {
    "id": 1,
    "name": "Jean Dupont",
    "email": "jean.dupont@email.com",
    "role": "user"
  }
}
```

**Response (401) - Erreur:**
```json
{
  "success": false,
  "message": "Identifiants invalides."
}
```

---

### Récupérer l'utilisateur connecté
**Endpoint:** `GET /user`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "id": 1,
  "name": "Jean Dupont",
  "email": "jean.dupont@email.com"
}
```

---

## Méditations

### Lister toutes les méditations
**Endpoint:** `GET /meditations`

**Headers:**
```
Content-Type: application/json
```

**Response (200):**
```json
[
  {
    "id": 1,
    "title": "Méditation du matin",
    "slug": "meditation-du-matin",
    "description": "Commencez votre journée avec calme et énergie.",
    "duration": 900,
    "media": {
      "id": 1,
      "title": "Audio méditation matin",
      "media_type": "audio",
      "file_path": "audios/meditation-matin.mp3",
      "duration": 900
    }
  }
]
```

---

### Afficher une méditation
**Endpoint:** `GET /meditations/{id}`

**Response (200):**
```json
{
  "id": 1,
  "title": "Méditation du matin",
  "slug": "meditation-du-matin",
  "description": "Commencez votre journée avec calme et énergie.",
  "duration": 900,
  "media": {
    "id": 1,
    "title": "Audio méditation matin",
    "media_type": "audio",
    "file_path": "audios/meditation-matin.mp3"
  }
}
```

---

### Créer une méditation (Admin uniquement)
**Endpoint:** `POST /meditations`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Body:**
```json
{
  "title": "Méditation du soir",
  "slug": "meditation-du-soir",
  "description": "Terminez votre journée en paix.",
  "duration": 1200,
  "media_title": "Audio méditation soir",
  "media_slug": "audio-meditation-soir",
  "file_path": "audios/meditation-soir.mp3",
  "media_duration": 1200
}
```

---

## Affirmations

### Lister toutes les affirmations
**Endpoint:** `GET /affirmations`

**Response (200):**
```json
[
  {
    "id": 1,
    "title": "Affirmation du jour",
    "body": "Je mérite le succès et le bonheur chaque jour.",
    "category_id": 1
  }
]
```

---

### Affirmations par catégorie
**Endpoint:** `GET /affirmations/category/{category_id}`

**Exemple:** `GET /affirmations/category/1`

**Response (200):**
```json
[
  {
    "id": 1,
    "title": "Affirmation du jour",
    "body": "Je mérite le succès et le bonheur chaque jour.",
    "category_id": 1
  }
]
```

---

### Créer une affirmation (Admin uniquement)
**Endpoint:** `POST /affirmations`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Body:**
```json
{
  "category_id": 1,
  "title": "Confiance en soi",
  "body": "Je suis capable de réaliser mes rêves."
}
```

---

## Événements

### Lister tous les événements
**Endpoint:** `GET /events`

**Response (200):**
```json
[
  {
    "id": 1,
    "title": "Retraite de méditation 2026",
    "description": "Un événement pour se ressourcer et méditer en groupe.",
    "event_date": "2026-03-15T09:00:00.000000Z",
    "location": "Centre Zen, Paris",
    "price": 120.00,
    "status": "upcoming",
    "media": [
      {
        "id": 1,
        "title": "Affiche de l'événement",
        "media_type": "image",
        "file_path": "images/events/affiche2026.jpg"
      }
    ]
  }
]
```

---

### Afficher un événement
**Endpoint:** `GET /events/{id}`

**Response (200):**
```json
{
  "id": 1,
  "title": "Retraite de méditation 2026",
  "description": "Un événement pour se ressourcer et méditer en groupe.",
  "event_date": "2026-03-15T09:00:00.000000Z",
  "location": "Centre Zen, Paris",
  "price": 120.00,
  "status": "upcoming",
  "media": [...]
}
```

---

### Créer un événement (Admin uniquement)
**Endpoint:** `POST /events`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Body:**
```json
{
  "title": "Retraite Yoga 2026",
  "description": "Séjour de yoga et méditation.",
  "event_date": "2026-04-20 10:00:00",
  "location": "Montagne, Alpes",
  "price": 299.00,
  "status": "upcoming",
  "images": [
    {
      "title": "Image principale",
      "slug": "yoga-2026-1",
      "file_path": "images/events/yoga1.jpg"
    }
  ]
}
```

---

## Blogs

### Lister tous les blogs
**Endpoint:** `GET /blogs`

**Response (200):**
```json
[
  {
    "id": 1,
    "title": "Les bienfaits de la méditation",
    "slug": "bienfaits-meditation",
    "description": "Découvrez comment la méditation peut transformer votre vie.",
    "body": "La méditation apporte calme, clarté et bien-être...",
    "author_id": 1,
    "is_premium": false,
    "media": [
      {
        "id": 1,
        "title": "Image principale",
        "media_type": "image",
        "file_path": "images/blogs/bienfaits1.jpg"
      }
    ]
  }
]
```

---

### Créer un blog (Admin uniquement)
**Endpoint:** `POST /blogs`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Body:**
```json
{
  "title": "Les bienfaits de la méditation",
  "slug": "bienfaits-meditation",
  "description": "Découvrez comment la méditation peut transformer votre vie.",
  "body": "La méditation apporte calme, clarté et bien-être.",
  "author_id": 1,
  "is_premium": false,
  "images": [
    {
      "title": "Image principale",
      "slug": "image-bienfaits-1",
      "file_path": "images/blogs/bienfaits1.jpg"
    }
  ]
}
```

---

## Plans de retraite

### Lister tous les plans de retraite
**Endpoint:** `GET /retreat-plans`

**Response (200):**
```json
[
  {
    "id": 1,
    "title": "Retraite Yoga & Méditation",
    "description": "Un séjour de 7 jours pour se ressourcer et pratiquer le yoga.",
    "duration_days": 7,
    "cover_image": "images/retreats/yoga2026.jpg",
    "features": ["Yoga quotidien", "Méditation guidée", "Repas bio"],
    "tags": ["yoga", "méditation", "bien-être"],
    "services": ["Hébergement", "Repas", "Ateliers"],
    "status": "available",
    "price": 499.99
  }
]
```

---

### Créer un plan de retraite
**Endpoint:** `POST /retreat-plans`

**Headers:**
```
Content-Type: application/json
```

**Body:**
```json
{
  "title": "Retraite Yoga & Méditation",
  "description": "Un séjour de 7 jours pour se ressourcer.",
  "duration_days": 7,
  "cover_image": "images/retreats/yoga2026.jpg",
  "features": ["Yoga quotidien", "Méditation guidée"],
  "tags": ["yoga", "méditation"],
  "services": ["Hébergement", "Repas"],
  "status": "available",
  "price": 499.99
}
```

---

## Journaux de gratitude

### Lister les journaux de gratitude d'un utilisateur
**Endpoint:** `GET /gratitude-journals/{userId}`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
[
  {
    "id": 1,
    "title": "Ma journée positive",
    "positive_thing_1": "J'ai passé un bon moment avec ma famille.",
    "positive_thing_2": "J'ai réussi à finir un projet important.",
    "positive_thing_3": "J'ai pris du temps pour méditer.",
    "journal_date": "2026-01-12"
  }
]
```

---

### Créer un journal de gratitude
**Endpoint:** `POST /gratitude-journals`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Body:**
```json
{
  "user_id": 1,
  "title": "Ma journée positive",
  "positive_thing_1": "J'ai passé un bon moment avec ma famille.",
  "positive_thing_2": "J'ai réussi à finir un projet important.",
  "positive_thing_3": "J'ai pris du temps pour méditer.",
  "journal_date": "2026-01-12"
}
```

**Response (201):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Ma journée positive",
    "positive_thing_1": "J'ai passé un bon moment avec ma famille.",
    "positive_thing_2": "J'ai réussi à finir un projet important.",
    "positive_thing_3": "J'ai pris du temps pour méditer.",
    "journal_date": "2026-01-12"
  }
}
```

---

## Formulaire Food Comfort

### Soumettre ou mettre à jour le formulaire
**Endpoint:** `POST /food-comfort-form`

**Headers:**
```
Content-Type: application/json
```

**Body:**
```json
{
  "first_name": "Marie",
  "last_name": "Durand",
  "has_allergies": false,
  "intolerances": "Gluten",
  "specific_diets": ["vegan"],
  "happiness_ingredients": ["fraise", "noix", "miel"],
  "disliked_foods": "Poivron",
  "spice_level": "releve",
  "culinary_inspirations": ["orientale", "terroir"],
  "comfort_dish": "Soupe de légumes",
  "breakfast_preference": "sale",
  "hot_drinks": ["infusion"],
  "plant_drinks": ["lait_avoine"],
  "needs_snacks": false,
  "free_comments": "Pas de préférence particulière.",
  "retreat_plan_id": 1
}
```

**Response (201):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "first_name": "Marie",
    "last_name": "Durand",
    "has_allergies": false,
    "intolerances": "Gluten",
    "specific_diets": ["vegan"],
    "happiness_ingredients": ["fraise", "noix", "miel"],
    "retreat_plan_id": 1
  }
}
```

---

## Paiements

### Payer un plan de retraite et créer/connecter un compte
Permet de payer un plan de retraite et de créer un compte utilisateur ou de se connecter si le compte existe déjà.

**Endpoint:** `POST /retreat-plans/{plan}/pay`

**Headers:**
```
Content-Type: application/json
```

**Body:**
```json
{
  "device_id": "unique-device-id-12345",
  "email": "jean.dupont@email.com",
  "password": "motdepasse123",
  "amount": 499.99,
  "currency": "EUR",
  "payment_method": "carte",
  "transaction_id": "TXN123456"
}
```

**Response (201):**
```json
{
  "success": true,
  "user": {
    "id": 1,
    "name": "jean.dupont@email.com",
    "email": "jean.dupont@email.com",
    "device_id": "unique-device-id-12345"
  },
  "payment": {
    "id": 1,
    "retreat_plan_id": 1,
    "user_id": 1,
    "amount": 499.99,
    "currency": "EUR",
    "status": "completed",
    "payment_method": "carte",
    "transaction_id": "TXN123456",
    "paid_at": "2026-01-12T14:30:00.000000Z"
  },
  "token": "3|abc123..."
}
```

---

## Codes d'erreur

| Code | Signification |
|------|---------------|
| 200  | Succès |
| 201  | Créé avec succès |
| 401  | Non autorisé (authentification requise) |
| 403  | Interdit (droits insuffisants) |
| 404  | Ressource non trouvée |
| 422  | Erreur de validation |
| 500  | Erreur serveur |

---

## Notes importantes

### Authentification
- Les routes marquées "Admin uniquement" nécessitent un token d'administrateur (role = 'admin')
- Les routes protégées nécessitent un token Bearer dans le header Authorization
- Le token est obtenu lors de l'inscription ou de la connexion

### Formats de données
- Les dates doivent être au format ISO 8601 : `YYYY-MM-DD` ou `YYYY-MM-DD HH:MM:SS`
- Les champs JSON (features, tags, services, etc.) sont des tableaux
- Les montants sont des nombres décimaux avec 2 chiffres après la virgule

### Médias
- Les blogs et événements peuvent avoir plusieurs images (galerie)
- Les méditations ont un seul média audio
- Les chemins de fichiers (file_path) doivent pointer vers des fichiers accessibles

### Objectifs disponibles (pour l'onboarding)
1. Paix interieur
2. Reduction du stress
3. Meilleur sommeil
4. Concentration
5. Energie vitale
6. Creativité
7. Confiance en soi
8. Relations harmonieuses

### Catégories d'affirmations disponibles
1. Confiance en soi
2. Paix interieure
3. Abondance
4. Santé
5. Amour
6. Reussite
