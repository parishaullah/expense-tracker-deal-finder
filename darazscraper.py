import re
from selenium import webdriver
from bs4 import BeautifulSoup

#from selenium.webdriver.common.keys import Keys
#import re
#import pandas as pd
#import os


browser = webdriver.Chrome(executable_path="C:\\Users\\USER\\Desktop\\chormy\\chromedriver.exe")
result=browser.get("https://www.daraz.com.bd/wow/i/bd/landingpage/flash-sale?spm=a2a0e.home.flashSale.1.11394591pfF4Dn&wh_weex=true&amp;wx_navbar_transparent=true&amp;scm=1003.4.icms-zebra-100031732-2896540.OTHER_5530854870_2643759&skuIds=132826107,129102257,150226795,100759876,125390702,165954211,124395632.html")
html_content_things = browser.page_source
browser.close()
soup = BeautifulSoup(html_content_things)
print(soup.prettify())
#print("hi")

#options = webdriver.ChromeOptions()
#options.add_experimental_option('excludeSwitches', ['enable-logging'])
#driver = webdriver.Chrome(options=options)


#list(soup.children)

# [type(item) for item in list(soup.children)]

#python die.py


#var= soup.find("div", class_="item-list-content")
#items = var.find_all("a")
#print(items[0])

#randomvar=items[0].find("div", class_="sale-title")
#print(randomvar)
#print(randomvar.text)

#finding price of product
#price_string = items[0].find("div", class_="sale-price").text
#price= re.findall(r'\d+', price_string)[0]
#print(price)

#finding the link to product
#wow= items[0].get("href")
#print(wow)


var= soup.find("div", class_="item-list-content")
items = var.find_all("a")

#loop
for item in items:
    prodname = item.find("div", class_="sale-title")
    print("Product name: ", prodname.text)

#finding price of product
    price_string = item.find("div", class_="sale-price").text
    price= re.findall(r'\d+', price_string)[0]
    print("Product price: ", price)

#finding the link to product
    wow= item.get("href")
    print("Product link: ", wow)

#finding image photo
    photo= item.find("img")
    pictor=photo.get("src")
    print("Product image: ", pictor)  
    print("\n")