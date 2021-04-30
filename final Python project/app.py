import mysql.connector
import operator
from flask import Flask, render_template, request, url_for, flash, redirect, session

import re
from selenium import webdriver
from bs4 import BeautifulSoup


def get_db_connection():
    conn = mysql.connector.connect(user="root", password='',
                                   host="localhost", database='expenses')
    return conn


app = Flask(__name__)
app.config['SECRET_KEY'] = 'this is the secret key'


@app.route('/')
def home():
    return render_template('home.html')


@app.route('/addTransactions', methods=('GET', 'POST'))
def addTransactions():
    if request.method == 'POST':
        category = request.form['category']
        description = request.form['description']
        amount = request.form['amount']

        if not amount:
            flash('Amount is required!')
        elif not category:
            flash('Category is required!')
        else:
            conn = get_db_connection()
            cursor = conn.cursor(dictionary=True)

            query = (
                "INSERT INTO transaction (tdescription, tamount)"
                "VALUES (%s, %s)"
            )
            data = (description, amount)
            cursor.execute(query, data)
            conn.commit()

            query = "SELECT cid from category where cname = %(cat)s"
            cursor.execute(query, {'cat': category})
            row = cursor.fetchone()
            cid = row['cid']
            tid = cursor.lastrowid
            cursor.fetchall()

            query = (
                "INSERT INTO belongs_to (cid, tid)"
                "VALUES (%s, %s)"
            )
            data = (cid, tid)
            cursor.execute(query, data)
            conn.commit()

            cursor.close()
            conn.close()
            return redirect(url_for('addTransactionsQ'))
    return render_template('addTransactions.html')


@app.route('/addTransactionsQ')
def addTransactionsQ():
    return render_template('addTransactionsQ.html')


@app.route('/viewTransactions', methods=('GET', 'POST'))
def viewTransactions():
    if request.method == 'POST':
        action = request.form['action']
        if action == 'category':
            category = request.form['category']
            conn = get_db_connection()
            cursor = conn.cursor(dictionary=True)
            query = (
                """select transaction.tid, tamount, tdescription, tdate from transaction
                join belongs_to on transaction.tid = belongs_to.tid
                join category on belongs_to.cid = category.cid where cname=%(cat)s"""
            )
            cursor.execute(query, {'cat': category})
            rows = cursor.fetchall()
            cursor.close()
            conn.close()
            session['rows'] = rows
            session['category'] = category
            return redirect(url_for('viewTransactionsQ'))
        elif action == 'period':
            fromDate = request.form['from']
            toDate = request.form['to']
            category = 'All'
            conn = get_db_connection()
            cursor = conn.cursor(dictionary=True)
            query = (
                """select transaction.tid, tamount, tdescription, tdate from transaction
                join belongs_to on transaction.tid = belongs_to.tid
                join category on belongs_to.cid = category.cid where cast(tdate as date) between cast(%(fromDate)s as date) and cast(%(toDate)s as date)
                order by tid"""
            )
            cursor.execute(query, {'fromDate': fromDate, 'toDate': toDate})
            rows = cursor.fetchall()
            cursor.close()
            conn.close()
            session['rows'] = rows
            session['category'] = category
            return redirect(url_for('viewTransactionsQ'))
        elif action == 'all':
            category = 'All'
            conn = get_db_connection()
            cursor = conn.cursor(dictionary=True)
            query = (
                """select transaction.tid, tamount, tdescription, tdate from transaction
                join belongs_to on transaction.tid = belongs_to.tid
                join category on belongs_to.cid = category.cid
                order by tid"""
            )
            cursor.execute(query)
            rows = cursor.fetchall()
            cursor.close()
            conn.close()
            session['rows'] = rows
            session['category'] = category
            return redirect(url_for('viewTransactionsQ'))
    return render_template('viewTransactions.html')


@app.route('/viewTransactionsQ', methods=('GET', 'POST'))
def viewTransactionsQ():
    rows = session['rows']
    category = session['category']
    if request.method == 'POST':
        rows.sort(key=operator.itemgetter('tamount'), reverse=True)
        return render_template('viewTransactionsQ.html', rows=rows, category=category)
    return render_template('viewTransactionsQ.html', rows=rows, category=category)


@app.route('/graph', methods=('GET', 'POST'))
def graph():
    if request.method == 'POST':
        fromDate = request.form['from']
        toDate = request.form['to']
        conn = get_db_connection()
        cursor = conn.cursor(dictionary=True)
        query = (
            """select category.cname, sum(tamount) as total from transaction
                join belongs_to on transaction.tid = belongs_to.tid
                join category on belongs_to.cid = category.cid where cast(tdate as date) between cast(%(fromDate)s as date) and cast(%(toDate)s as date)
                group by cname"""
        )
        cursor.execute(query, {'fromDate': fromDate, 'toDate': toDate})
        rows = cursor.fetchall()
        sum = 0
        for row in rows:
            sum += row['total']
        query = (
            """select tamount as maxAmount, tdescription from transaction
                join belongs_to on transaction.tid = belongs_to.tid
                join category on belongs_to.cid = category.cid where cast(tdate as date) between cast(%(fromDate)s as date) and cast(%(toDate)s as date)
                order by tamount desc
                limit 1"""
        )
        cursor.execute(query, {'fromDate': fromDate, 'toDate': toDate})
        maxTransaction = cursor.fetchone()
        cursor.fetchall()
        cursor.close()
        conn.close()
        return render_template('periodicGraph.html', rows=rows, fromDate=fromDate, toDate=toDate, sum=sum,
                               maxTransaction=maxTransaction)
    conn = get_db_connection()
    cursor = conn.cursor(dictionary=True)

    # query for getting sum of transactions in each category
    query = (
        """select category.cname, sum(tamount) as total from transaction
            join belongs_to on transaction.tid = belongs_to.tid
            join category on belongs_to.cid = category.cid
            group by cname"""
    )
    cursor.execute(query)
    rows = cursor.fetchall()

    # find total spent
    sum = 0
    for row in rows:
        sum += row['total']

    # query for finding largest transaction
    query = (
        """select max(tamount) as maxAmount, tdescription from transaction
            join belongs_to on transaction.tid = belongs_to.tid
            join category on belongs_to.cid = category.cid"""
    )
    cursor.execute(query)
    maxTransaction = cursor.fetchone()
    cursor.fetchall()

    # query for finding amount spent in each category in each month
    query = (
        """select category.cname, sum(tamount) as total, year(tdate) as tyear, month(tdate) as tmonth from transaction
            join belongs_to on transaction.tid = belongs_to.tid
            join category on belongs_to.cid = category.cid
            group by year(tdate), month(tdate), cname"""
    )
    cursor.execute(query)
    rows2 = cursor.fetchall()
    cursor.close()
    conn.close()

    # ['Month', 'Bills', 'Electronics', 'Communications', 'Food', 'Monthly Total']
    comboRows = [[0] * 6 for i in range(3)]
    monthSums = [0] * 3
    for row in rows2:
        i = row['tmonth']
        comboRows[i - 2][0] = i
        monthSums[i - 2] += row['total']
        if row['cname'] == 'Bills':
            comboRows[i - 2][1] = row['total']
        elif row['cname'] == 'Electronics':
            comboRows[i - 2][2] = row['total']
        elif row['cname'] == 'Communications':
            comboRows[i - 2][3] = row['total']
        else:
            comboRows[i - 2][4] = row['total']
    return render_template('graph.html', rows=rows, sum=sum, maxTransaction=maxTransaction,
                           comboRows=comboRows, monthSums=monthSums)


@app.route('/deals', methods=('GET', 'POST'))
def deals():
    browser = webdriver.Chrome(executable_path="C:\\Users\\paris\\Downloads\\chromedriver.exe")
    result = browser.get(
        "https://www.daraz.com.bd/wow/i/bd/landingpage/flash-sale?spm=a2a0e.home.flashSale.1.11394591pfF4Dn&wh_weex=true&amp;wx_navbar_transparent=true&amp;scm=1003.4.icms-zebra-100031732-2896540.OTHER_5530854870_2643759&skuIds=132826107,129102257,150226795,100759876,125390702,165954211,124395632.html")
    html_content_things = browser.page_source
    browser.close()
    soup = BeautifulSoup(html_content_things)
    soup.prettify()

    var = soup.find("div", class_="item-list-content")
    items = var.find_all("a")

    names = []
    prices = []
    links = []

    for item in items:
        prodname = item.find("div", class_="sale-title")
        names.append(prodname.text)

        price_string = item.find("div", class_="sale-price").text
        price = re.findall(r'\d+', price_string)[0]
        prices.append(price)

        wow = item.get("href")
        links.append(wow)

    n = len(names)
    return render_template('deals.html', names=names, prices=prices, links=links, n=n)


if __name__ == '__main__':
    app.run()
