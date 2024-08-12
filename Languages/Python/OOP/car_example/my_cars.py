from car import Car
from electric_car import ElectricCar as EC

my_beetle = Car('volkswagen', 'beetle', 2016)
print(my_beetle.get_descriptive_name())
my_beetle.read_odometer()
print()
my_tesla = EC('tesla', 'roadster', 2016)
print(my_tesla.get_descriptive_name())
my_tesla.battery.get_range()
