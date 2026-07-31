import { test, expect } from '@playwright/test';

test.describe('Course LMS & Quiz E2E Test', () => {
  test('Fresh user can view course modules, answer quiz correctly, and see green feedback', async ({ page }) => {
    // Register fresh user for clean test state
    const email = `quiz_user_${Date.now()}@cs2.id`;
    await page.goto('http://127.0.0.1:8000/register');
    await page.fill('input[name="name"]', 'Quiz User');
    await page.fill('input[name="email"]', email);
    await page.fill('input[name="password"]', 'Password123!');
    await page.fill('input[name="password_confirmation"]', 'Password123!');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.href.includes('/register'));

    // Navigate to Course 1
    await page.goto('http://127.0.0.1:8000/courses/1');
    await page.click('.module-item[data-id="1"]');

    // Option B (index 1) is correct
    const optionB = page.locator('#qo-1');
    await expect(optionB).toBeVisible();
    await optionB.click();

    // Option B turns green
    await expect(optionB).toHaveClass(/cor/);

    // Feedback shows correct
    const fb = page.locator('#qz-fb');
    await expect(fb).toBeVisible();
    await expect(fb).toHaveClass(/cor/);
    await expect(fb).toContainText('Benar');

    // Next button is visible
    const nextBtn = page.locator('#qz-nxt');
    await expect(nextBtn).toBeVisible();
  });

  test('Answering wrong option shows Coba Lagi retry button, clicking retry allows answering correctly', async ({ page }) => {
    // Register fresh user
    const email = `retry_user_${Date.now()}@cs2.id`;
    await page.goto('http://127.0.0.1:8000/register');
    await page.fill('input[name="name"]', 'Retry User');
    await page.fill('input[name="email"]', email);
    await page.fill('input[name="password"]', 'Password123!');
    await page.fill('input[name="password_confirmation"]', 'Password123!');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.href.includes('/register'));

    // Navigate to Course 1
    await page.goto('http://127.0.0.1:8000/courses/1');
    await page.click('.module-item[data-id="1"]');

    // 1. Click Wrong Option A (index 0)
    const optionA = page.locator('#qo-0');
    await expect(optionA).toBeVisible();
    await optionA.click();

    // Option A turns red (wrn)
    await expect(optionA).toHaveClass(/wrn/);

    // Feedback shows wrong
    const fb = page.locator('#qz-fb');
    await expect(fb).toBeVisible();
    await expect(fb).toHaveClass(/wrn/);
    await expect(fb).toContainText('Salah');

    // Next button turns into "Coba Lagi 🔄"
    const nextBtn = page.locator('#qz-nxt');
    await expect(nextBtn).toBeVisible();
    await expect(nextBtn).toContainText('Coba Lagi');

    // 2. Click "Coba Lagi"
    await nextBtn.click();

    // Verify options are enabled again (not disabled)
    await expect(optionA).not.toHaveClass(/dis/);
    await expect(optionA).not.toHaveClass(/wrn/);

    // 3. Now click Correct Option B (index 1)
    const optionB = page.locator('#qo-1');
    await optionB.click();

    // Option B turns green
    await expect(optionB).toHaveClass(/cor/);
    await expect(fb).toHaveClass(/cor/);
    await expect(fb).toContainText('Benar');
  });
});
