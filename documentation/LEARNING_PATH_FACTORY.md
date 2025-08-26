# Learning Path Factory Documentation

## Overview

Factory untuk membuat data testing/seeding Learning Path dan Learning Path Steps.

## Factories Created

### 1. LearningPathFactory

Location: `database/factories/LearningPathFactory.php`

**Default attributes:**

-   `title`: Random sentence (3 words)
-   `description`: Random paragraph (2 sentences)
-   `is_published`: 80% chance to be true
-   `created_by`: Random name
-   `modified_by`: Random name
-   `created_at`: Random date between 3 months ago and now
-   `updated_at`: Random date between 1 month ago and now

**Available states:**

-   `published()`: Force is_published to true
-   `unpublished()`: Force is_published to false

### 2. LearningPathStepFactory

Location: `database/factories/LearningPathStepFactory.php`

**Default attributes:**

-   `title`: Random sentence (2 words)
-   `description`: Random sentence (5 words)
-   `order`: Random number between 1-10
-   `learning_path_id`: Must be provided
-   `course_id`: Must be provided
-   `created_at`: Random date between 2 months ago and now
-   `updated_at`: Random date between 1 month ago and now

## Usage Examples

### Create single Learning Path

```php
$path = \App\Models\LearningPath::factory()->create();
```

### Create published Learning Path

```php
$path = \App\Models\LearningPath::factory()->published()->create();
```

### Create Learning Path with custom data

```php
$path = \App\Models\LearningPath::factory()->create([
    'title' => 'Custom Learning Path',
    'description' => 'Custom description',
    'is_published' => true
]);
```

### Create Learning Path with Steps

```php
$path = \App\Models\LearningPath::factory()->create();

// Create steps for this path
for ($i = 1; $i <= 5; $i++) {
    \App\Models\LearningPathStep::factory()->create([
        'learning_path_id' => $path->id,
        'course_id' => \App\Models\Course::inRandomOrder()->first()->id,
        'order' => $i
    ]);
}
```

### Create multiple Learning Paths

```php
\App\Models\LearningPath::factory(10)->create();
```

## Seeder

Location: `database/seeders/LearningPathSeeder.php`

**What it creates:**

-   4 predefined learning paths with realistic content
-   5 additional random learning paths
-   Each learning path has 3-8 steps
-   **All steps are linked to existing published courses** (from CourseFactory)
-   Uses smart course distribution to avoid repetition within same learning path

**Course Integration:**

-   Fetches all published courses at start of seeding
-   Distributes courses evenly across learning paths
-   Avoids using same course twice in same learning path when possible
-   Resets course pool if all courses used within a path
-   **No new courses created - only uses existing course seeder data**

**Run seeder:**

```bash
php artisan db:seed --class=LearningPathSeeder
```

**Sample Learning Paths created:**

1. Full Stack Web Development (5 steps) - Uses 5 different courses
2. UI/UX Design Mastery (4 steps) - Uses 4 different courses
3. Data Science Foundations (5 steps) - Uses 5 different courses
4. Digital Marketing Strategy (3 steps, unpublished) - Uses 3 different courses

## Testing Data

After running seeder, you'll have:

-   ~9 learning paths total
-   ~41 learning path steps total
-   Mix of published and unpublished paths
-   **100% of steps linked to real existing courses** (no null course_id)
-   Smart course distribution avoiding repetition within same path

## Integration with DatabaseSeeder

The LearningPathSeeder is called in DatabaseSeeder.php **after** courses are created, ensuring all steps can be linked to real published courses from the CourseFactory.

## Optimizations Made

-   **Course Reuse Prevention**: Avoids using same course multiple times in same learning path
-   **Smart Distribution**: Uses all 50 available courses across different learning paths
-   **Error Handling**: Gracefully handles if no courses available
-   **Performance**: Loads all courses once, distributes efficiently

## Factory Features

-   Realistic fake data using Faker
-   Proper relationships between paths and steps
-   Published/unpublished states
-   Proper ordering of steps
-   Integration with existing Course model
