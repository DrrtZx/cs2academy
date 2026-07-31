import { test, expect } from '@playwright/test';

test.describe('End of Course Navigation E2E Test', () => {
  test('Completing all course modules redirects to course catalog with completion banner', async ({ page }) => {
    // Fresh user
    const email = `eoc_user_${Date.now()}@cs2.id`;
    await page.goto('http://127.0.0.1:8000/register');
    await page.fill('input[name="name"]', 'End User');
    await page.fill('input[name="email"]', email);
    await page.fill('input[name="password"]', 'Password123!');
    await page.fill('input[name="password_confirmation"]', 'Password123!');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.href.includes('/register'));

    // Open Course 1
    await page.goto('http://127.0.0.1:8000/courses/1');

    // Helper: answer all 4 questions in a module
    async function answerFourQuestions(answers) {
      for (let i = 0; i < answers.length; i++) {
        const isLast = (i === answers.length - 1);
        if (isLast) {
          const resp = page.waitForResponse(r => r.url().includes('/complete'));
          await page.click(`#qo-${answers[i]}`);
          await resp;
        } else {
          await page.click(`#qo-${answers[i]}`);
          await page.click('#qz-nxt');
        }
      }
    }

    // Complete Module 1 (Q1:1, Q2:1, Q3:1, Q4:0)
    await page.click('.module-item[data-id="1"]');
    await answerFourQuestions([1, 1, 1, 0]);
    await page.click('#qz-nxt');

    // Complete Module 2 (Q1:1, Q2:1, Q3:1, Q4:2)
    await page.click('.module-item[data-id="2"]');
    await answerFourQuestions([1, 1, 1, 2]);
    await page.click('#qz-nxt');

    // Complete Module 3 (Q1:1, Q2:1, Q3:1, Q4:1)
    await page.click('.module-item[data-id="3"]');
    await answerFourQuestions([1, 1, 1, 1]);
    await page.click('#qz-nxt');

    // Complete Module 4 (Final module) (Q1:0, Q2:1, Q3:1, Q4:1)
    await page.click('.module-item[data-id="4"]');
    await answerFourQuestions([0, 1, 1, 1]);

    // Verify button says "Selesaikan Kursus 🎉"
    const nextBtn = page.locator('#qz-nxt');
    await expect(nextBtn).toBeVisible();
    await expect(nextBtn).toContainText('Selesaikan Kursus');

    // Click Selesaikan Kursus
    await nextBtn.click();

    // Verify redirect to catalog with completion query
    await page.waitForURL((url) => url.href.includes('/courses') && url.href.includes('completed=1'));

    // Verify completion banner appears
    const banner = page.locator('.catalog-wrap');
    await expect(banner).toContainText('Selamat! Kamu telah menyelesaikan seluruh modul');
  });
});
