# Projet-DevWEB
Il serait nécessaire de disposer d'un site web qui regroupe différentes offres de stage, et qui permettra de stocker les données des entreprises ayant déjà pris un stagiaire, ou qui en recherchent un.
# StageForMe

Site web de recherche de stage — Projet A2 CESI.

---

## 🗺️ Indexation & SEO — `sitemap.xml` et `robots.txt`

Ces deux fichiers sont placés à la **racine du projet** (au même niveau que `index.php`) et constituent la base du référencement naturel du site StageForMe auprès des moteurs de recherche (Google, Bing, etc.).

---

### `sitemap.xml`

Le sitemap est un fichier XML qui liste toutes les pages **publiques et indexables** du site. Il permet aux robots des moteurs de recherche de les découvrir plus rapidement et de comprendre leur importance relative.

#### Format utilisé

Le fichier respecte le standard **Sitemaps Protocol 0.9** (`xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"`), reconnu par tous les grands moteurs de recherche.

Chaque entrée `<url>` contient quatre balises :

| Balise | Rôle |
|---|---|
| `<loc>` | URL absolue de la page |
| `<lastmod>` | Date de dernière modification (format ISO 8601 : `YYYY-MM-DD`) |
| `<changefreq>` | Fréquence estimée de mise à jour (`daily`, `weekly`, `monthly`, `yearly`) |
| `<priority>` | Importance relative de la page, de `0.0` à `1.0` |

#### Pages incluses et justification

| URL | Priorité | Fréquence | Raison |
|---|---|---|---|
| `/` | 1.0 | weekly | Page d'accueil, point d'entrée principal du site |
| `/recherche` | 0.9 | daily | Page la plus utile pour le SEO : les offres de stage changent fréquemment, c'est le cœur du produit |
| `/connexion` | 0.8 | monthly | Page publique nécessaire pour l'accès au service |
| `/mentions-legales` | 0.3 | yearly | Obligatoire légalement, mais sans valeur SEO forte |

#### Pages volontairement exclues

Les pages suivantes ne sont **pas** dans le sitemap car elles nécessitent une session authentifiée et n'ont aucune valeur pour un moteur de recherche :

- `/dashboard` — tableau de bord pilote
- `/admin` — interface administrateur
- `/postulation` — formulaire de candidature
- `/change-password` — changement de mot de passe
- `/pilote-create-student` et `/admin-create-user` — création de comptes

Indexer ces pages serait inutile (elles redirigent vers la connexion) et potentiellement problématique pour la sécurité.

---

### `robots.txt`

Le fichier `robots.txt` est lu en premier par tous les robots d'indexation avant qu'ils ne visitent le site. Il indique ce qu'ils sont **autorisés ou interdits** de crawler.

#### Directive `User-agent: *`

La règle s'applique à **tous** les robots (Googlebot, Bingbot, etc.). On pourrait créer des règles spécifiques par robot, mais une règle universelle est suffisante ici.

#### Pages publiques autorisées

```
Allow: /$
Allow: /connexion
Allow: /recherche
Allow: /recherche.fiche
Allow: /mentions-legales
```

Ces directives `Allow` sont explicites pour lever toute ambiguïté en cas de conflit avec une règle `Disallow` plus large.

#### Zones bloquées et justification

| Règle | Raison |
|---|---|
| `Disallow: /dashboard` | Zone authentifiée, sans valeur SEO |
| `Disallow: /admin` | Interface d'administration, ne doit jamais être indexée |
| `Disallow: /pilote` | Zone réservée aux pilotes, authentifiée |
| `Disallow: /postulation` | Formulaire privé lié à une offre spécifique |
| `Disallow: /change-password` | Page sensible, aucun intérêt SEO |
| `Disallow: /user-created` | Page de confirmation post-création de compte |
| `Disallow: /vendor/` | Dossier des dépendances Composer — **ne doit jamais être exposé** |
| `Disallow: /src/` | Code source PHP (controllers, templates Twig…) — idem |
| `Disallow: /.env` | Fichier de configuration sensible (credentials BDD, clés…) |
| `Disallow: /composer.json` et `/composer.lock` | Révèlent la liste des dépendances, inutile à indexer |

> ⚠️ **Note importante :** bloquer ces chemins dans `robots.txt` ne remplace pas une vraie protection serveur. Le `.htaccess` déjà en place (`Require all denied` sur `.env`) doit être étendu pour couvrir `/vendor/` et `/src/` si ce n'est pas déjà le cas côté serveur Apache.

#### Gestion du duplicate content sur la pagination

```
Disallow: /recherche?*page=
Allow: /recherche?*
```

Ces deux règles combinées autorisent l'indexation de la page de recherche avec des filtres (mots-clés, type d'offre…) mais **bloquent les pages de pagination** (`?page=2`, `?page=3`…). Sans ça, Google pourrait indexer des dizaines d'URLs quasi-identiques avec un contenu différent selon les offres du moment, ce qui dilue le référencement.

#### Déclaration du sitemap

```
Sitemap: https://www.stageforme.fr/sitemap.xml
```

Cette ligne indique directement aux robots où trouver le sitemap, sans avoir à le soumettre manuellement dans Google Search Console (même si cette soumission manuelle reste recommandée).

---

### Mise en place

1. Placer `sitemap.xml` et `robots.txt` à la **racine du projet**, au même niveau que `index.php`
2. Remplacer `https://www.stageforme.fr` par le vrai domaine de production dans les deux fichiers
3. Mettre à jour `<lastmod>` dans le sitemap à chaque déploiement significatif
4. Soumettre le sitemap dans **Google Search Console** et **Bing Webmaster Tools** pour accélérer l'indexation initiale
5. *(Recommandé)* Ajouter une balise `<link rel="canonical" href="…">` dans le `<head>` de chaque page publique pour éviter tout duplicate content lié aux paramètres d'URL
