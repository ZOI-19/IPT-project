<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp" rel="stylesheet" />
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

:root{
    --color-primary: #7380ec;
    --color-danger: #ff7782;
    --color-success: #41f1b6;   
    --color-warning: #ffbb55;
    --color-white: #fff;
    --color-info-dark: #7d8da1; 
    --color-info-light: #dceleb;
    --color-dark: #363949;
    --color-light: rgba(132, 139, 200, 0.18);
    --color-primary-variant: #111e88;
    --color-dark-variant: #677483;
    --color-background: #f6f6f9;
    
    --card-border-radius: 2rem;
    --border-radius-1: 0.4rem;
    --border-radius-2: 0.8rem;
    --border-radius-3: 1.2rem;

    --card-padding: 1.8rem;
    --padding-1: 1.2rem;

    --box-shadow: 0 2rem 3rem var(--color-light);
}

.dark-theme-variable{
    --color-background: #181a1e;
    --color-white: #202528;
    --color-dark: #edeffd;
    --color-dark-variant: #a3bdcc;
    --color-light: rgba(0, 0, 0, 0.4);
    --box-shadow: 0 2rem 3rem var(--color-light);
}
*{
    margin: 0;
    padding: 0;
    outline: 0;
    appearance: none;
    border: 0;
    text-decoration: none;
    list-style: none;
    box-sizing: border-box;
}

html{
    font-size: 14px;
}

body{
    width: 100vw;
    height: 100vh;
    font-family: poppins, sans-serif;
    font-size: 0.88rem;
    background: var(--color-background);
    user-select: none;
    overflow: hidden;
    color: var(--color-dark);
}

.container{
    display: grid;
    width: 100%;
    margin: 0 auto;
    gap: 1.8rem;
    grid-template-columns: 14rem auto 23rem;
}


a{
    color: var(--color-dark);
}

aside{
    height: 100vh;
    background: white;
}

aside .top{
    background: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1.4rem;
}

aside .logo{
    display: flex;
    gap: 0.8rem;
}

aside .logo img{
    width: 2rem;
    height: 2rem;
}

aside .close{
    display: none;
}

/* == SIDEBAR ==*/
aside .sidebar{
    display: flex;
    flex-direction: column;
    height: 90vh;
    position: relative;
    top: 3rem;
}

aside h3{
    font-weight: 500;
}

aside .sidebar a{
    display: flex;
    color: var(--color-info-dark);
    margin: 1rem;
    gap: 1rem;
    align-items: center;
    position: relative;
    height: 3.7rem;
    transition: all 300ms ease;
}

aside .sidebar a span{
    font-size: 1.6rem,;
    transition: all 300ms ease;
}

aside .sidebar a:last-child{
    position: absolute;
    bottom: 2rem;
    width: 100%;
}

aside .sidebar a.active{
    background: var(--color-light);
    color: var(--color-primary);
    margin-left: 0;
}

aside .sidebar a.active::before{
    content: '';
    width: 6px;
    height: 100%;
    background:  var(--color-primary);
}

aside .sidebar a.active span{
    color: var(--color-primary);
    margin-left: calc(1rem - 3px);
}

aside .sidebar a:hover{
    color: var(--color-primary);
}

aside .sidebar a:hover span{
    margin-left: 1rem;
}

aside .sidebar .message-count span{
    background: var(--color-danger);
    color: var(--color-white);
    padding: 2px 10px;
    font-size: 11px;
    border-radius: var(--border-radius-1);
}

.Categories {
      width: 100%;
      display: flex;
      justify-content: center;
      margin-top: 10px;
    }

    .Categories ul {
      display: flex;
      list-style: none;
      gap: 40px;
      align-items: center;
      justify-content: center;
      margin: 0;
      border-bottom: 2px solid #ccc;
    }

    .Categories ul li {
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      position: relative;
    }

    .Categories ul li::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: -5px;
      width: 0;
      height: 3px;
      background-color: yellow;
      transition: width 0.3s ease-in-out;
    }

    .Categories ul li:hover::after {
      width: 100%;
    }

</style>
<body>
<div class="left-side">
    <aside>
            <div class="top">
                <div class="logo">
                    <img src="img - Copy\SSD.jpeg" alt="">
                    <h2 class="danger">Delizeus Kai Food Products</h2>
                </div>
                <div class="close" id="close-btn">
                <span class="material-symbols-sharp">close</span>
                </div>
            </div>
            <div class="sidebar">
                <a href="Dashboard.php">
                    <span class="material-symbols-sharp">dashboard</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="Orders.php">
                    <span class="material-symbols-sharp">receipt_long</span>
                    <h3>Orders</h3>
                </a>
                <a href="ViewCustomers.php" class="active">
                    <span class="material-symbols-sharp">groups</span>
                    <h3>View Customers</h3>
                </a>
                <a href="Inventory.php">
                    <span class="material-symbols-sharp">inventory_2</span>
                    <h3>Inventory</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-sharp">mail</span>
                    <h3>Message</h3>
                    <span class="message-count">26</span>
                </a>
                <a href="#">
                    <span class="material-symbols-sharp">settings</span>
                    <h3>Settings</h3>
                </a>
                <a href="#" class="Logout">
                    <span class="material-symbols-sharp">logout</span>
                    <h3>Logout</h3>
                </a>  
            </div>
        </aside>
        <main>
            <nav class="Categories">
                <ul>
                    <li>All Orders</li>
                    <li>Packing</li>
                    <li>Dispatch</li>
                    <li>Complete</li>
                </ul>
            </nav>

        </main>
    </div>
</body>
</html>