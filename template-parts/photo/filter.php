<div class="filters">

  <!-- Filtre Catégories -->
  <?php
  $categories = get_terms([
    'taxonomy' => 'categorie',
    'hide_empty' => false
  ]);
  ?>
  <select id="filter-categorie">
    <option value="">Toutes les catégories</option>
    <?php foreach ($categories as $cat) : ?>
      <option value="<?php echo $cat->slug; ?>">
        <?php echo $cat->name; ?>
      </option>
    <?php endforeach; ?>
  </select>

  <!-- Filtre Formats -->
  <?php
  $formats = get_terms([
    'taxonomy' => 'format',
    'hide_empty' => false
  ]);
  ?>
  <select id="filter-format">
    <option value="">Tous les formats</option>
    <?php foreach ($formats as $format) : ?>
      <option value="<?php echo $format->slug; ?>">
        <?php echo $format->name; ?>
      </option>
    <?php endforeach; ?>
  </select>

  <!-- Filtre Tri par date -->
  <select id="filter-date">
    <option value="desc">Plus récentes</option>
    <option value="asc">Plus anciennes</option>
  </select>

</div>