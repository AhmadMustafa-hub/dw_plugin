import React, { useEffect, useState } from "react";
import axios from "axios";
import {
  LineChart,
  Line,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
} from "recharts";
import "./App.css";

const App = () => {
  const [data, setData] = useState([]);
  const [range, setRange] = useState("7");
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchData = async () => {
      setLoading(true); 
      const endDate = new Date().toISOString().split("T")[0];
      const startDate = new Date();
      startDate.setDate(startDate.getDate() - parseInt(range) + 1);
      const formattedStartDate = startDate.toISOString().split("T")[0];
      const baseUrl =
        window.location.origin +
        window.location.pathname.split("/wp-admin/")[0];
      const apiUrl = `${baseUrl}/wp-json/dw/v1/data`;
      try {
        const response = await axios.get(apiUrl, {
          params: {
            start_date: formattedStartDate,
            end_date: endDate,
          },
        });
        setData(response.data);
      } catch (error) {
        console.error("There was an error fetching the data", error);
      } finally {
        setLoading(false);  
      }
    };
    fetchData();
  }, [range]);

  const handleChangeRange = (e) => {
    setRange(e.target.value);
  };

  return (
    <div className="App" style={{ width: "100%", height: 295 }}>
      <select
        value={range}
        onChange={handleChangeRange}
        className="filter-dropdown"
      >
        <option value="7">Last 7 days</option>
        <option value="15">Last 15 days</option>
        <option value="30">Last 30 days</option>
      </select>
      {loading ? (
        <p className="no-data">Loading...</p>  
      ) : data.length > 0 ? (
        <ResponsiveContainer width="100%" height="100%">
          <LineChart
            width={500}
            height={300}
            data={data.sort((a, b) => new Date(a.date) - new Date(b.date))}
          >
            <Line type="monotone" dataKey="value" stroke="#8884d8" />
            <CartesianGrid stroke="#ccc" />
            <XAxis dataKey="date" />
            <YAxis />
            <Tooltip />
          </LineChart>
        </ResponsiveContainer>
      ) : (
        <p className="no-data">No Data Available</p>
      )}
    </div>
  );
};

export default App;
