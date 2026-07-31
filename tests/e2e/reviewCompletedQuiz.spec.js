import { test, expect } from '@playwright/test';

test.describe('Completed Module Review E2E Test', () => {
  test('Re-visiting a completed module displays the correct answer in green with explanation banner', async ({ page }) => {
    // 1. Login
    await page.goto('http://127.0.0.1:8000/login');
    await page.fill('input[name="email"]', 'demo@cs2.id');
    await page.fill('input[name="password"]', 'Demo1234!');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.href.includes('/login'));

    // 2. Open Course 1 (Aim & Movement)
    await page.goto('http://127.0.0.1:8000/courses/1');

    // Click Module 1 (Crosshair Placement)
    await page.click('.module-item[data-id="1"]');

    // Verify option B is highlighted in GREEN (cor class)
    const optionB = page.locator('#qo-1');
    await expect(optionB).toBeVisible();
    await expect(optionB).toHaveClass(/cor/);
    await expect(optionB).toHaveClass(/dis/);

    // Verify explanation box is visible and shows correct answer rationale
    const fb = page.locator('#qz-fb');
    await expect(fb).toBeVisible();
    await expect(fb).toContainText('Jawaban Benar');

    // Verify next button is visible
    const nxtBtn = page.locator('#qz-nxt');
    await expect(nxtBtn).toBeVisible();
  });
});
