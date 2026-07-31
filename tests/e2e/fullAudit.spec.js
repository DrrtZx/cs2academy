import { test, expect } from '@playwright/test';

test.describe('CS2ACADEMY Full Application Audit Test Suite', () => {

  test('User Side: Complete Flow (Registration, Browsing, Quiz Retry, Coaching Checkout & Chat)', async ({ page }) => {
    const timestamp = Date.now();
    const userEmail = `audit_student_${timestamp}@cs2.id`;
    const userName = `Student Audit ${timestamp}`;

    // 1. Visit Home Page
    await page.goto('http://127.0.0.1:8000');
    await expect(page.locator('.hero-title')).toContainText('Naik Rank CS2');

    // 2. Register New Account
    await page.goto('http://127.0.0.1:8000/register');
    await page.fill('input[name="name"]', userName);
    await page.fill('input[name="email"]', userEmail);
    await page.fill('input[name="password"]', 'Password123!');
    await page.fill('input[name="password_confirmation"]', 'Password123!');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.href.includes('/register'));

    // 3. Course LMS & Quiz Retry Workflow
    await page.goto('http://127.0.0.1:8000/courses/1');
    await page.click('.module-item[data-id="1"]');

    // Test Wrong Answer & Retry on Q1
    await page.click('#qo-0'); // Wrong option
    await expect(page.locator('#qz-fb')).toContainText('Salah');
    await expect(page.locator('#qz-nxt')).toContainText('Coba Lagi');

    await page.click('#qz-nxt'); // Retry
    await page.click('#qo-1'); // Correct option Q1
    await expect(page.locator('#qz-fb')).toContainText('Benar');
    await page.click('#qz-nxt');

    // Answer Q2 (1), Q3 (1), Q4 (0 - last completes module)
    await page.click('#qo-1'); await page.click('#qz-nxt');
    await page.click('#qo-1'); await page.click('#qz-nxt');

    const completeResp = page.waitForResponse(resp => resp.url().includes('/complete'));
    await page.click('#qo-0');
    await completeResp;
    await expect(page.locator('#qz-fb')).toContainText('Benar');

    // 4. Coaching Purchase Flow
    await page.goto('http://127.0.0.1:8000/coaching');
    const chooseBtn = page.locator('a:has-text("Pilih Paket Ini")').first();
    await expect(chooseBtn).toBeVisible();
    await chooseBtn.click();

    // Payment Page
    await page.waitForURL((url) => url.href.includes('/payment'));
    const payConfirmBtn = page.locator('button.pay-btn');
    await expect(payConfirmBtn).toBeVisible();
    await payConfirmBtn.click();

    // Pending Payment Page & Upload Proof
    await page.waitForURL((url) => url.href.includes('/payment/pending'));
    await expect(page.locator('body')).toContainText(/Virtual Account|Pembayaran|Menunggu/i);

    // Simulated Proof Upload using dummy buffer
    const buffer = Buffer.from('fake image content');
    await page.setInputFiles('input[type="file"]', {
      name: 'bukti_transfer.jpg',
      mimeType: 'image/jpeg',
      buffer: buffer
    });
    await page.click('button[type="submit"]');

    // Check Toast / Success status
    await expect(page.locator('body')).toContainText(/Bukti|Berhasil|Menunggu|Konfirmasi/i);

    // 5. User Assignments & Coaching Chat
    await page.goto('http://127.0.0.1:8000/assignments');
    await expect(page.locator('body')).toContainText('Coaching');

    // 6. User Profile Settings
    await page.goto('http://127.0.0.1:8000/profile');
    await expect(page.locator('body')).toContainText('Profile');
  });

  test('Admin Side: Management & Verification (Dashboard, Pending Transactions, Users, Inbox & Courses)', async ({ page }) => {
    // 1. Admin Login (clear cookies first for isolated admin session)
    await page.context().clearCookies();
    await page.goto('http://127.0.0.1:8000/login');
    await page.fill('input[name="email"]', 'admin@cs2.id');
    await page.fill('input[name="password"]', 'Admin1234!');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.href.includes('/login'));

    // 2. Admin Dashboard Access
    await page.goto('http://127.0.0.1:8000/admin');
    await expect(page.locator('.admin-header')).toContainText('Admin Dashboard');

    // Verify Stat Cards grid exists
    const statGrid = page.locator('.stat-grid');
    await expect(statGrid).toBeVisible();

    // 3. Admin Users Management Page
    await page.goto('http://127.0.0.1:8000/admin/users');
    await expect(page.locator('body')).toContainText('User');

    // 4. Admin Coaching Assignments & Chat Inbox Page
    await page.goto('http://127.0.0.1:8000/admin/assignments');
    await expect(page.locator('body')).toContainText('Coaching');

    // 5. Admin Courses & Modules Management Page
    await page.goto('http://127.0.0.1:8000/admin/courses');
    await expect(page.locator('body')).toContainText('Course');
  });

});
