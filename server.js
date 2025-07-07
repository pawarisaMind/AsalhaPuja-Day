const http = require('http');
const fs = require('fs');
const path = require('path');

// สร้างเซิร์ฟเวอร์
const server = http.createServer((req, res) => {
  // ถ้าไม่มีการร้องขอไฟล์ ระบุให้โหลด index.html
  let filePath = path.join(__dirname, req.url === '/' ? 'index.html' : req.url);

  // ดึงนามสกุลไฟล์ เช่น .html, .css, .png
  const extname = path.extname(filePath).toLowerCase();

  // กำหนด Content-Type ตามนามสกุล
  const types = {
    '.html': 'text/html; charset=utf-8',
    '.css': 'text/css',
    '.js': 'text/javascript',
    '.png': 'image/png',
    '.jpg': 'image/jpeg',
    '.jpeg': 'image/jpeg',
    '.gif': 'image/gif',
    '.svg': 'image/svg+xml',
    '.mp3': 'audio/mpeg',
    '.ttf': 'font/ttf',
    '.otf': 'font/otf',
    '.woff': 'font/woff',
    '.woff2': 'font/woff2'
  };

  // หากไม่รู้จักนามสกุล จะให้เป็น html
  const contentType = types[extname] || 'application/octet-stream';

  // อ่านไฟล์ที่ร้องขอ
  fs.readFile(filePath, (err, data) => {
    if (err) {
      res.writeHead(404, { 'Content-Type': 'text/plain; charset=utf-8' });
      res.end('ไม่พบไฟล์ที่ร้องขอ: ' + filePath);
    } else {
      res.writeHead(200, { 'Content-Type': contentType });
      res.end(data);
    }
  });
});

// เริ่มรันเซิร์ฟเวอร์
server.listen(3000, () => {
  console.log('✅ Server running at http://localhost:3000');
});
