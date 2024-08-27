const express = require('express');
const bodyParser = require('body-parser');
const cookieParser = require('cookie-parser');
const csrf = require('csurf');
const app = express();
const PORT = 3000;

// Sử dụng bodyParser, cookieParser và csrf
app.use(bodyParser.urlencoded({ extended: true }));
app.use(cookieParser());
app.use(csrf({ cookie: true }));
app.set('view engine', 'ejs');
app.use(express.static('public'));

// Cơ sở dữ liệu giả
const users = [
  { id: 1, username: 'admin', password: 'admin' }
];

app.get('/', (req, res) => {
  res.render('index');
});

// Blind SQL Injection
app.get('/sql_injection', (req, res) => {
  res.render('sql_injection');
});

app.post('/sql_injection', (req, res) => {
  const username = req.body.username;
  const password = req.body.password;
  
  const user = users.find(user => user.username === username && user.password === password);
  if (user) {
    res.send('Login successful!');
  } else {
    res.send('Incorrect login information!');
  }
});

// Cross-Site Scripting (XSS)
app.get('/xss', (req, res) => {
  res.render('xss');
});

app.post('/xss', (req, res) => {
  const input = req.body.input;
  res.send(`You entered: ${input}`);
});

// Insecure Deserialization
app.get('/deserialize', (req, res) => {
  res.render('deserialize');
});

app.post('/deserialize', (req, res) => {
  const data = req.body.data;
  const obj = JSON.parse(data);
  res.send(`Deserialized data: ${obj}`);
});

// Broken Authentication và Session Management
app.get('/login', (req, res) => {
  res.render('login');
});

app.post('/login', (req, res) => {
  const { username, password } = req.body;
  const user = users.find(user => user.username === username && user.password === password);
  if (user) {
    req.session.user = user;
    res.send('Logged in!');
  } else {
    res.send('Login failed');
  }
});

// Remote Code Execution (RCE)
const { exec } = require('child_process');
app.get('/rce', (req, res) => {
  res.render('rce');
});

app.post('/rce', (req, res) => {
  const command = req.body.command;
  exec(command, (error, stdout, stderr) => {
    if (error) {
      res.send(`Error: ${stderr}`);
    } else {
      res.send(`Output: ${stdout}`);
    }
  });
});

// Session Fixation
app.get('/session_fixation', (req, res) => {
  res.cookie('sessionID', '123456');
  res.render('session_fixation');
});


// Sử dụng bodyParser và cookieParser
//app.use(bodyParser.urlencoded({ extended: true }));
app.use(cookieParser());


// Sử dụng CSRF protection middleware
app.use(csrf({ cookie: true }));

// Middleware để đặt token CSRF trong tất cả các yêu cầu POST
app.use((req, res, next) => {
  res.locals.csrfToken = req.csrfToken();
  next();
});

// Route để hiển thị trang có lỗ hổng CSRF
app.get('/csrf', (req, res) => {
  res.render('csrf');
});

// Xử lý yêu cầu POST từ trang có lỗ hổng CSRF
app.post('/transfer', (req, res) => {
    // Kiểm tra token CSRF
    if (req.body.csrfToken !== req.csrfToken()) {
      return res.status(403).send('Invalid CSRF token');
    }
  
    const recipient = req.body.recipient;
    const amount = parseFloat(req.body.amount);
  
    // Kiểm tra xem người dùng có đủ tiền để chuyển không
    if (req.session.balance < amount) {
      return res.status(400).send('Insufficient balance');
    }
  
    // Thực hiện chuyển tiền
    req.session.balance -= amount;
    // Đối với mục đích minh họa, giả sử chuyển tiền thành công
    res.send(`Transfer of $${amount} to ${recipient} completed successfully.`);
  });
  


app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
