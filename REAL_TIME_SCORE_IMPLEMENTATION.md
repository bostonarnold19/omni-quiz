# Real-Time Score Implementation

## Overview
This document describes the implementation of real-time score tracking for both Mock Exams and Qualifying Exams in the Omni-Quiz application.

## Changes Made

### 1. Backend Updates (PHP - Laravel)

#### File: `app/Http/Controllers/Student/QuestionnaireController.php`

**Changes in `create()` method (Lines 157-180):**
- Added real-time score calculation that counts correct answers after each question
- Now returns current score and total items in the response
- Calculates score using: `whereHas('answer', function($query) { $query->where('is_correct', 1); })`

**Changes in `store()` method (Lines 292-315):**
- Similar real-time score calculation added for answer submissions
- Returns updated score and items count after each answer submission

**What this does:**
- After each answer submission, the backend calculates how many questions the student has answered correctly so far
- Returns this information to the frontend so it can be displayed in real-time

### 2. Frontend Updates - Mock Exam (JavaScript)

#### File: `public/js/exam-mode.js`

**Changes:**
1. Added `showScore: true` to the Vue data object (enables score display)
2. Updated score tracking in multiple AJAX success callbacks:
   - Initial question load (mounted hook)
   - Skip button functionality
   - Next button functionality

**What this does:**
- Receives score updates from the backend after each answer
- Updates the Vue data properties (score and items)
- Automatically triggers view updates to show current score

### 3. Frontend Updates - Qualifying Exam (JavaScript)

#### File: `public/js/question.js`

**Changes:**
1. Added `showScore: true` to the Vue data object
2. Updated score tracking in all AJAX success callbacks:
   - Initial question load
   - Skip functionality
   - Answer submission (nextBtn)

**What this does:**
- Same functionality as mock exam, but for qualifying exams (is_official = 1)

### 4. View Updates - Mock Exam

#### File: `resources/views/modules/exam_mode/index.blade.php`

**Changes:**
- Added real-time score display section below "Items Left"
- Shows: "Current Score: X / Y (Z%)"
- Styled with blue color (#259ade) to match the application theme
- Only displays when `showScore` is true

### 5. View Updates - Qualifying Exam

#### File: `resources/views/modules/questionnaire/create.blade.php`

**Changes:**
- Added identical real-time score display as mock exam
- Shows: "Current Score: X / Y (Z%)"
- Same styling and behavior

## How It Works

### Flow Diagram:

```
1. Student starts exam (Mock or Qualifying)
   ↓
2. First question loads with initial score (0/total)
   ↓
3. Student selects an answer and clicks "Accept"
   ↓
4. Backend receives answer and saves it
   ↓
5. Backend calculates current score:
   - Counts all answered questions
   - Counts how many were correct
   ↓
6. Backend returns next question + current score
   ↓
7. Frontend updates display with new score
   ↓
8. Repeat steps 3-7 for each question
   ↓
9. When exam completes, show final score
```

### Score Calculation Logic:

The score is calculated using Laravel's Eloquent relationships:

```php
$currentScore = $this->answer
    ->where('user_id', $auth->id)
    ->where('questionnaire_code_id', $questionnaire_code->id)
    ->whereHas('answer', function($query) {
        $query->where('is_correct', 1);
    })
    ->count();
```

This queries:
- All answers submitted by the current user
- For the current exam session (questionnaire_code_id)
- Where the selected option (answer) is marked as correct
- Returns the count of correct answers

## Display Format

The score is displayed as:
- **Current Score: 15 / 30 (50.0%)**
  - 15 = Number of correct answers so far
  - 30 = Total number of questions in the exam
  - 50.0% = Percentage score calculated in real-time

## Key Features

1. **Real-Time Updates**: Score updates after every answer submission
2. **Percentage Display**: Shows both raw score and percentage
3. **Works for Both Exam Types**: 
   - Mock Exam (is_official = 0)
   - Qualifying Exam (is_official = 1)
4. **Non-Intrusive**: Display is positioned clearly but doesn't interfere with exam flow
5. **Consistent Styling**: Matches the application's existing design theme

## Testing Recommendations

To test this feature:

1. **Mock Exam Test:**
   - Go to dashboard
   - Select a subject and start a mock exam
   - Answer questions and observe the score updating
   - Verify score increases when correct answers are selected

2. **Qualifying Exam Test:**
   - Enter a qualifying exam code
   - Start the exam
   - Answer questions and observe real-time score
   - Verify score calculation accuracy

3. **Edge Cases to Test:**
   - Skip button functionality (score should remain same)
   - Timer expiration (final score should be accurate)
   - Refresh during exam (score should persist)
   - Multiple exam sessions (scores should be independent)

## Browser Compatibility

This implementation uses:
- Vue.js 2.x (already in the project)
- Standard JavaScript ES5
- CSS3 for styling
- Compatible with all modern browsers

## Performance Considerations

- Score calculation is efficient (single database query)
- Minimal overhead on each answer submission
- No additional database tables required
- Uses existing relationships and indexes

## Future Enhancements (Optional)

Possible improvements that could be added later:
1. Score history graph (show score progression over time)
2. Correct/incorrect answer indicators after submission
3. Category-wise score breakdown
4. Comparison with average scores
5. Toggle to hide/show score during exam

## Notes

- The `$XXXXXXXXXXX` variable name in the original code was preserved to avoid breaking existing functionality
- The `showScore` flag allows easy toggle of the feature if needed
- No database migrations required - uses existing schema
- Backward compatible with existing exam sessions

